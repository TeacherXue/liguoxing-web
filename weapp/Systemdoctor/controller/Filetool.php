<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海南赞赞网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 小虎哥 <1105415366@qq.com>
 * Date: 2018-06-28
 */

namespace weapp\Systemdoctor\controller;

use think\Db;
use think\Page;
use weapp\Systemdoctor\logic\FiletoolLogic;

/**
 * 插件的控制器
 */
class Filetool extends Base
{
    // 在线文件管理
    public $filetoolLogic;
    public $baseDir = '';
    public $maxDir = '';
    public $globalTpCache = array();
    public $upfilename = '';

    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        $this->filetoolLogic = new FiletoolLogic;
        $this->globalTpCache = $this->filetoolLogic->globalTpCache;
        $this->baseDir = $this->filetoolLogic->baseDir; // 服务器站点根目录绝对路径
        $this->maxDir = $this->filetoolLogic->maxDir; // 默认文件管理的最大级别目录
    }

    /**
     * 文件管理首页
     */
    public function index()
    {
        // 获取到所有GET参数
        $param = input('param.', '', null);
        $activepath = input('param.activepath', '', null);
        $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
        
        // 安全过滤路径
        $activepath = $this->safeProcessPath($activepath);

        /*当前目录路径*/
        $activepath = !empty($activepath) ? $activepath : $this->maxDir;
        $tmp_max_dir = preg_replace("#\/#i", "\/", $this->maxDir);
        if (!preg_match("#^".$tmp_max_dir."#i", $activepath)) {
            $activepath = $this->maxDir;
        }
        /*--end*/

        $inpath = "";
        $activepath = preg_replace("#^\/{1,}#", "/", $activepath); // 多个斜杆替换为单个斜杆
        if($activepath == "/") $activepath = "";

        if(empty($activepath)) {
            $inpath = $this->baseDir.$this->maxDir;
        } else {
            $inpath = $this->baseDir.$activepath;
        }
        
        // 路径规范化并再次验证
        $real_inpath = realpath($inpath);
        $real_base = realpath($this->baseDir.$this->maxDir);

        if (!$real_inpath || strpos($real_inpath, $real_base) !== 0) {
            $this->error('访问的路径不合法');
        }

        $list = $this->filetoolLogic->getDirFile($inpath, $activepath);
        $assign_data['list'] = $list;

        /*文件操作*/
        $assign_data['replaceImgOpArr'] = $this->filetoolLogic->replaceImgOpArr;
        $assign_data['editOpArr'] = $this->filetoolLogic->editOpArr;
        $assign_data['renameOpArr'] = $this->filetoolLogic->renameOpArr;
        $assign_data['delOpArr'] = $this->filetoolLogic->delOpArr;
        $assign_data['moveOpArr'] = $this->filetoolLogic->moveOpArr;
        /*--end*/

        $assign_data['activepath'] = $activepath;

        $this->assign($assign_data);
        return $this->fetch('filetool/index');
    }

    /**
     * 安全处理路径参数
     */
    private function safeProcessPath($path)
    {
        // 移除所有..路径片段
        $path = str_replace('..', '', $path);
        
        // 移除危险字符
        $path = str_replace(['\\', ':', '?', '*', '|', '<', '>', '"', "'"], '', $path);
        
        // 规范化路径分隔符
        $path = str_replace('\\', '/', $path);
        
        // 移除连续的斜杠
        $path = preg_replace('#/{2,}#', '/', $path);
        
        // 移除路径开头的斜杠
        // $path = ltrim($path, '/');
        
        return $path;
    }

    /**
     * 替换图片
     */
    public function replace_img()
    {
        $this->error('功能不存在');
        if (IS_POST) {
            $post = input('post.', '', null);
            $activepath = !empty($post['activepath']) ? trim($post['activepath']) : '';
            if (empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $file = request()->file('upfile');
            if (empty($file)) {
                $this->error('请选择上传图片！');
                exit;
            } else {
                $image_type = tpCache('basic.image_type');
                $fileExt = !empty($image_type) ? str_replace('|', ',', $image_type) : config('global.image_ext');
                $image_upload_limit_size = intval(tpCache('basic.file_size') * 1024 * 1024);
                $result = $this->validate(
                    ['file' => $file],
                    ['file'=>'image|fileSize:'.$image_upload_limit_size.'|fileExt:'.$fileExt],
                    ['file.image' => '上传文件必须为图片','file.fileSize' => '上传文件过大','file.fileExt'=>'上传文件后缀名必须为'.$fileExt]
                );
                if (true !== $result || empty($file)) {
                    $this->error($result);
                    exit;
                }
            }

            $res = $this->filetoolLogic->upload('upfile', $activepath, $post['filename'], 'image');
            if ($res['code'] == 1) {
                $this->success('操作成功！',weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            } else {
                $this->error($res['msg'],weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            }
        }

        $filename = input('param.filename/s', '', null);

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
        if ($activepath == "") $activepathname = "根目录";
        else $activepathname = $activepath;

        $info = array(
            'activepath'    => $activepath,
            'activepathname'    => $activepathname,
            'filename'  => $filename,
        );
        $this->assign('info', $info);
        return $this->fetch('filetool/replace_img');
    }

    /**
     * 新建文件
     */
    public function newfile()
    {
        if (IS_POST) {
            $post = input('post.', '', null);
            $content = input('post.content', '', null);
            $filename = !empty($post['filename']) ? trim($post['filename']) : '';
            $content = !empty($content) ? $content : '';
            $activepath = !empty($post['activepath']) ? trim($post['activepath']) : '';

            if (empty($filename) || empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $r = $this->filetoolLogic->editFile($filename, $activepath, $content);
            if ($r === true) {
                $this->success('操作成功！',weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
                exit;
            } else {
                $this->error($r);
                exit;
            }
        }

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
        $filename = 'newfile.htm';
        $content = "";
        $info = array(
            'filename'  => $filename,
            'activepath'=> $activepath,
            'content'   => $content,
            'extension' => 'text/html',
        );
        $this->assign('info', $info);
        return $this->fetch('filetool/newfile');
    }

    /**
     * 文件管理编辑
     */
    public function edit()
    {
        if (IS_POST) {
            $post = input('post.', '', null);
            $content = input('post.content', '', null);
            $filename = !empty($post['filename']) ? trim($post['filename']) : '';
            $content = !empty($content) ? $content : '';
            $activepath = !empty($post['activepath']) ? trim($post['activepath']) : '';

            if (empty($filename) || empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $r = $this->filetoolLogic->editFile($filename, $activepath, $content);
            if ($r === true) {
                $this->success('操作成功！',weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
                exit;
            } else {
                $this->error($r);
                exit;
            }
        }

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);

        $filename = input('param.filename/s', '', null);
        if (!stristr($filename, '.')) {
            $this->error('无效文件名');
        }

        $activepath = str_replace("..", "", $activepath);
        $filename = str_replace("..", "", $filename);
        $path_parts  = pathinfo($filename);
        $path_parts['extension'] = strtolower($path_parts['extension']);

        /*不允许越过指定最大级目录的文件编辑*/
        $tmp_max_dir = preg_replace("#\/#i", "\/", $this->filetoolLogic->maxDir);
        if (!preg_match("#^".$tmp_max_dir."#i", $activepath)) {
            $this->error('没有操作权限！');
            exit;
        }
        /*--end*/

        /*允许编辑的文件类型*/
        if (!in_array($path_parts['extension'], $this->filetoolLogic->editExt)) {
            $this->error('只允许操作文件类型如下：'.implode('|', $this->filetoolLogic->editExt));
            exit;
        }
        /*--end*/

        /*读取文件内容*/
        $file = $this->baseDir."$activepath/$filename";
        $content = "";
        if(is_file($file))
        {
            $filesize = filesize($file);
            if (0 < $filesize) {
                $fp = fopen($file, "r");
                $content = fread($fp, $filesize);
                fclose($fp);
                if ('css' != $path_parts['extension']) {
                    $content = htmlspecialchars($content, ENT_QUOTES);
                    $content = preg_replace("/(@)?eval(\s*)\(/i", 'intval(', $content);
                    // $content = preg_replace("/\?\bphp\b/i", "？ｍｕｍａ", $content);
                }
            }
        }
        /*--end*/

        if($path_parts['extension'] == 'js'){
            $extension = 'text/javascript';
        } else if($path_parts['extension'] == 'css'){
            $extension = 'text/css';
        } else if($path_parts['extension'] == 'php'){
            $extension = 'text/x-php';
        } else {
            $extension = 'text/html';
        }

        $info = array(
            'filename'  => $filename,
            'activepath'=> $activepath,
            'extension' => $extension,
            'content'   => $content,
        );
        $this->assign('info', $info);
        return $this->fetch('filetool/edit');
    }

    /**
     * 新建目录
     * @return [type] [description]
     */
    public function newdir()
    {
        if (IS_POST) {
            $dirname = input('post.dirname/s');
            $dirname = trim($dirname);
            if (empty($dirname)) {
                $this->error('目录名不能为空！');
            } else if (preg_match('/([\\|\/|\:|\*|\?|\"|\<|\>|\|]+)/i', $dirname)) {
                $this->error('不能包含下列任何字符：\ / : * ? " < > |');
            }

            $activepath = input('param.activepath', '', null);
            $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
            if (!is_dir($this->baseDir.$activepath)) {
                $this->error("{$activepath} 不存在");
            }
            $newdir = $dirname;
            $dirname = $this->baseDir.$activepath."/".$dirname;
            if (is_writable($this->baseDir.$activepath)) {
                if (!file_exists($dirname)) {
                    tp_mkdir($dirname, 0755);
                    chmod($dirname, 0755);
                }
                $this->success('创建成功', weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath."/".$newdir, ':', false))));
            } else {
                $this->error('创建失败，因为这个位置不允许写入！', weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            }
        }
        $this->error('操作失败');
    }

    /**
     * 重命名
     * @return [type] [description]
     */
    public function resetname()
    {
        if (IS_POST) {
            $old_filename = input('post.old_filename/s');
            $old_filename = trim($old_filename);
            $dirname = input('post.dirname/s');
            $dirname = trim($dirname);
            if (empty($dirname)) {
                $this->error('目录名不能为空！');
            } else if (preg_match('/([\\|\/|\:|\*|\?|\"|\<|\>|\|]+)/i', $dirname)) {
                $this->error('不能包含下列任何字符：\ / : * ? " < > |');
            }

            $activepath = input('param.activepath', '', null);
            $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
            if (!is_dir($this->baseDir.$activepath)) {
                $this->error("{$activepath} 不存在");
            }

            $oldname = $this->baseDir.$activepath."/".$old_filename;
            $newname = $this->baseDir.$activepath."/".$dirname;
            if (is_writable($oldname)) {
                if (($newname != $oldname)) {
                    $r = @rename($oldname, $newname);
                    if ($r === false) {
                        $this->error('重命名失败，检查php环境是否支持 rename 函数');
                    }
                }
                $this->success('重命名成功', weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            } else {
                if (is_dir($oldname)) {
                    $this->error("【{$oldname}】目录没有可写权限");
                } else {
                    $this->error("【{$oldname}】文件没有可写权限");
                }
            }
        }
        $this->error('操作失败');
    }

    /**
     * 删除文件
     * @return [type] [description]
     */
    public function del()
    {
        if (IS_POST) {
            $filename = input('param.filename/s');
            $filename = trim($filename);
            if (empty($filename)) {
                $this->error('目录名不能为空！');
            }

            $activepath = input('param.activepath', '', null);
            $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
            if (!is_dir($this->baseDir.$activepath)) {
                $this->error("{$activepath} 不存在");
            }

            $filename = $this->baseDir.$activepath."/{$filename}";
            $filename = iconv("utf-8", "gb2312//IGNORE", $filename); // 转换编码
            if (is_file($filename)) {
                @unlink($filename);
                $t = "文件";
            } else {
                $t = "目录";
                if (true) {
                    $this->filetoolLogic->RmDirFiles($filename);
                } else {
                    $this->error("系统禁止删除{$t}", weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
                }
            }
            $this->success("删除成功", weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
        }
        $this->error('操作失败');
    }

    /**
     * 移动文件
     */
    public function movefile()
    {
        if (IS_POST) {
            $filename = input('param.filename/s');
            $filename = trim($filename);
            if (empty($filename)) {
                $this->error('缺少文件名参数！');
            }

            $activepath = input('param.activepath', '', null);
            $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
            if (!is_dir($this->baseDir.$activepath)) {
                $this->error("缺少当前位置参数！");
            }

            $newpath = input('param.newpath/s');
            $newpath = $this->filetoolLogic->replace_path(trim($newpath), ':', true);
            if (!empty($newpath) && !preg_match("#\.\.#", $newpath)) {

            }
            else
            {
                $this->error('对不起，你移动的路径不合法！');
            }
        }

        $filename = input('param.filename/s');
        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);
        $assign_data = [
            'filename'  => $filename,
            'activepath'=> $activepath,
        ];
        $this->assign($assign_data);
        return $this->fetch('filetool/movefile');
    }

    /**
     * 文件上传
     */
    public function uploadfile()
    {
        header('Content-Type: text/html; charset=utf-8');
        function_exists('set_time_limit') && set_time_limit(0);
        @ini_set('memory_limit','-1');

        if (IS_AJAX_POST) {
            $activepath = input('param.activepath', '', null);
            $activepath = $this->filetoolLogic->replace_path($activepath, ':', true);

            // 获取定义的上传最大参数
            $max_file_size = intval(tpCache('basic.file_size') * 1024 * 1024);
            // 获取上传的文件信息
            $files = request()->file();
            // 若获取不到则定义为空
            $file  = !empty($files['file']) ? $files['file'] : '';

            /*判断上传文件是否存在错误*/
            if(empty($file)){
                $this->error('文件过大或文件已损坏！');
            }
            $error = $file->getError();
            if(!empty($error)){
                $this->error($error);
            }

            $image_type = tpCache('basic.image_type');
            $media_type = tpCache('basic.media_type');
            $file_type = tpCache('basic.file_type');
            $file_type .= !empty($file_type) ? "|{$image_type}" : '';
            $file_type .= !empty($file_type) ? "|{$media_type}" : '';
            $file_type = str_replace('|', ',', $file_type);
            if(empty($file_type)){
                $this->error('没有设置文件上传格式！');
            }

            $result = $this->validate(
                ['file' => $file],
                ['file'=>'fileSize:'.$max_file_size.'|fileExt:'.$file_type],
                ['file.fileSize' => '上传文件过大','file.fileExt'=>'上传文件后缀名必须为'.$file_type]
            );
            if (true !== $result || empty($file)) {
                $this->error($result);
            }
            /*--end*/

            // 移动到框架应用根目录/public/uploads/ 目录下
            $savePath = $this->baseDir.$activepath."/";
            // 定义文件名
            $fileName    = $file->getInfo('name');
            // 提取文件名后缀
            // $file_ext    = pathinfo($fileName, PATHINFO_EXTENSION);
            // 提取出文件名，不包括扩展名
            // $newfileName = preg_replace('/\.([^\.]+)$/', '', $fileName);
            // 过滤文件名.\/的特殊字符，防止利用上传漏洞
            // $newfileName = preg_replace('#(\\\|\/|\.)#i', '', $newfileName);
            // 过滤后的新文件名
            // $fileName = $newfileName.'.'.$file_ext;
            // 中文转码
            $this->upfilename = iconv("utf-8","gb2312//IGNORE",$fileName);

            // 使用自定义的文件保存规则
            $info = $file->rule(function ($file) {
                return $this->upfilename;
            })->move($savePath);
            if ($info) {
                $this->success("上传成功", weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            }else{
                $this->error($info->getError(), weapp_url('Systemdoctor/Filetool/index', array('activepath'=>$this->filetoolLogic->replace_path($activepath, ':', false))));
            }
        }
    }
}