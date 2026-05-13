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
 * Date: 2018-4-3
 */

namespace app\admin\controller;
use app\admin\controller\Base;
use think\Controller;
use think\Db;
use app\admin\logic\FilemanagerLogic;

class Filemanager extends Base
{
    public $filemanagerLogic;
    public $baseDir = '';
    public $maxDir = '';
    public $globalTpCache = array();

    public function _initialize() {
        parent::_initialize();
        $this->filemanagerLogic = new FilemanagerLogic(); 
        $this->globalTpCache = $this->filemanagerLogic->globalTpCache;
        $this->baseDir = $this->filemanagerLogic->baseDir; // 服务器站点根目录绝对路径
        $this->maxDir = $this->filemanagerLogic->maxDir; // 默认文件管理的最大级别目录
    }

    public function index()
    {
        // 安全修复：防止目录遍历攻击
        
        // 1. 获取并初步清理用户输入
        $activepath = input('param.activepath', '', null);
        $activepath = $this->filemanagerLogic->replace_path($activepath, ':', true);

        /*当前目录路径*/
        $activepath = !empty($activepath) ? $activepath : $this->maxDir;
        
        // 2. 移除所有危险字符（../ .\ 等）
        $activepath = str_replace(['..', '\\', "\0"], '', $activepath);
        
        // 3. 规范化多个斜杆为单个斜杆
        $activepath = preg_replace("#\/{2,}#", "/", $activepath);
        if ($activepath == "/") {
            $activepath = "";
        }
        
        // 4. 字符白名单验证（只允许字母、数字、下划线、连字符、斜杆）
        if (!empty($activepath) && !preg_match('#^[a-zA-Z0-9_\-/]+$#', $activepath)) {
            $this->error('路径包含非法字符');
        }
        
        // 5. 检查路径前缀（必须以 maxDir 开头）
        $tmp_max_dir = preg_replace("#\/#i", "\/", $this->maxDir);
        if (!preg_match("#^".$tmp_max_dir."#i", $activepath)) {
            $activepath = $this->maxDir;
        }
        
        // 6. 构建完整路径
        $inpath = "";
        if (empty($activepath)) {
            $inpath = $this->baseDir . $this->maxDir;
        } else {
            $inpath = $this->baseDir . $activepath;
        }
        
        // 7. 使用 realpath 规范化路径（这是最关键的防护）
        $base_path = realpath($this->baseDir . $this->maxDir);
        $real_path = realpath($inpath);
        
        // 8. 如果路径不存在或不在允许的目录范围内，拒绝访问
        if (false === $real_path || false === $base_path) {
            $this->error('目录不存在');
        }
        
        // 9. 检查规范化后的路径是否在允许的范围内
        if (0 !== strpos($real_path, $base_path)) {
            $this->error('非法路径访问，禁止目录穿越');
        }
        
        // 10. 验证通过，使用规范化后的路径
        $inpath = $real_path;

        $list = $this->filemanagerLogic->getDirFile($inpath, $activepath);
        $assign_data['list'] = $list;

        /*文件操作*/
        $assign_data['replaceImgOpArr'] = $this->filemanagerLogic->replaceImgOpArr;
        $assign_data['editOpArr'] = $this->filemanagerLogic->editOpArr;
        $assign_data['renameOpArr'] = $this->filemanagerLogic->renameOpArr;
        $assign_data['delOpArr'] = $this->filemanagerLogic->delOpArr;
        $assign_data['moveOpArr'] = $this->filemanagerLogic->moveOpArr;
        /*--end*/

        $assign_data['activepath'] = $activepath;

        $this->assign($assign_data);
        return $this->fetch();
    }


    /**
     * 替换图片
     */
    public function replace_img()
    {
        if (IS_POST) {
            $post = input('post.', '', null);
            $activepath = !empty($post['activepath']) ? trim($post['activepath']) : '';
            
            // 安全修复：验证路径
            $activepath = $this->validatePath($activepath);
            if (empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $file = request()->file('upfile');
            if (empty($file)) {
                $this->error('请选择上传图片！');
                exit;
            } else {
                $image_type = tpCache('global.image_type');
                $fileExt = !empty($image_type) ? str_replace('|', ',', $image_type) : config('global.image_ext');
                $image_upload_limit_size = intval(tpCache('global.file_size') * 1024 * 1024);
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

            $res = $this->filemanagerLogic->upload('upfile', $activepath, $post['filename'], 'image');
            if ($res['code'] == 1) {
                $this->success('操作成功！', url('Filemanager/index', array('activepath'=>$this->filemanagerLogic->replace_path($activepath, ':', false))));
            } else {
                $this->error($res['msg'], url('Filemanager/index', array('activepath'=>$this->filemanagerLogic->replace_path($activepath, ':', false))));
            }
        }

        $filename = input('param.filename/s', '', null);

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filemanagerLogic->replace_path($activepath, ':', true);
        
        // 安全修复：验证路径
        $activepath = $this->validatePath($activepath);
        
        if ($activepath == "") $activepathname = "根目录";
        else $activepathname = $activepath;

        $info = array(
            'activepath'    => $activepath,
            'activepathname'    => $activepathname,
            'filename'  => $filename,
        );
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (IS_POST) {
            $post = input('post.', '', null);
            $content = input('post.content', '', null);
            $filename = !empty($post['filename']) ? trim($post['filename']) : '';
            $content = !empty($content) ? $content : '';
            $activepath = !empty($post['activepath']) ? trim($post['activepath']) : '';
            
            // 安全修复：验证路径和文件名
            $activepath = $this->validatePath($activepath);
            $filename = $this->validateFilename($filename);
            
            // 安全修复：禁止编辑系统关键文件
            if (!$this->checkForbiddenFile($filename)) {
                $this->error('禁止编辑系统关键文件');
                exit;
            }

            if (empty($filename) || empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $r = $this->filemanagerLogic->editFile($filename, $activepath, $content);
            if ($r === true) {
                $this->success('操作成功！', url('Filemanager/index', array('activepath'=>$this->filemanagerLogic->replace_path($activepath, ':', false))));
                exit;
            } else {
                $this->error($r, null, [], 8);
                exit;
            }
        }

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filemanagerLogic->replace_path($activepath, ':', true);

        $filename = input('param.filename/s', '', null);

        // 安全修复：验证路径和文件名
        $activepath = $this->validatePath($activepath);
        $filename = $this->validateFilename($filename);
        
        // 安全修复：禁止编辑系统关键文件
        if (!$this->checkForbiddenFile($filename)) {
            $this->error('禁止编辑系统关键文件');
            exit;
        }
        
        $path_parts  = pathinfo($filename);
        $path_parts['extension'] = strtolower($path_parts['extension']);

        /*不允许越过指定最大级目录的文件编辑*/
        $tmp_max_dir = preg_replace("#\/#i", "\/", $this->filemanagerLogic->maxDir);
        if (!preg_match("#^".$tmp_max_dir."#i", $activepath)) {
            $this->error('没有操作权限！');
            exit;
        }
        /*--end*/
        
        /*允许编辑的文件类型*/
        if (!in_array($path_parts['extension'], $this->filemanagerLogic->editExt)) {
            $this->error('只允许操作文件类型如下：'.implode('|', $this->filemanagerLogic->editExt));
            exit;
        }
        /*--end*/
        
        // 安全修复：额外检查 - 严格限制可编辑文件类型，不包括 php
        $safe_edit_ext = ['txt', 'htm', 'html', 'css', 'js', 'json'];
        if (!in_array($path_parts['extension'], $safe_edit_ext)) {
            $this->error('出于安全考虑，只允许编辑以下类型文件：'.implode(', ', $safe_edit_ext));
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
                if ('htm' == $path_parts['extension']) {
                    $content = htmlspecialchars($content, ENT_QUOTES);
                    foreach ($this->filemanagerLogic->disableFuns as $key => $val) {
                        $val_new = msubstr($val, 0, 1).'-'.msubstr($val, 1);
                        $content = preg_replace("/(@)?".$val."(\s*)\(/i", "{$val_new}(", $content);
                    }
                }
            }
        }
        /*--end*/

        if($path_parts['extension'] == 'js'){
            $extension = 'text/javascript';
        } else if($path_parts['extension'] == 'css'){
            $extension = 'text/css';
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
        return $this->fetch();
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
            
            // 安全修复：验证路径和文件名
            $activepath = $this->validatePath($activepath);
            $filename = $this->validateFilename($filename);
            
            // 安全修复：禁止编辑系统关键文件
            if (!$this->checkForbiddenFile($filename)) {
                $this->error('禁止编辑系统关键文件');
                exit;
            }

            if (empty($filename) || empty($activepath)) {
                $this->error('参数有误');
                exit;
            }

            $r = $this->filemanagerLogic->editFile($filename, $activepath, $content);
            if ($r === true) {
                $this->success('操作成功！', url('Filemanager/index', array('activepath'=>$this->filemanagerLogic->replace_path($activepath, ':', false))));
                exit;
            } else {
                $this->error($r, null, [], 8);
                exit;
            }
        }

        $activepath = input('param.activepath/s', '', null);
        $activepath = $this->filemanagerLogic->replace_path($activepath, ':', true);
        
        // 安全修复：验证路径
        $activepath = $this->validatePath($activepath);
        
        $filename = 'newfile.htm';
        $content = "";
        $info = array(
            'filename'  => $filename,
            'activepath'=> $activepath,
            'content'   => $content,
            'extension' => 'text/html',
        );
        $this->assign('info', $info);
        return $this->fetch();
    }
    
    /**
     * 安全函数：验证路径，防止目录穿越
     * @param string $path 待验证的路径
     * @return string 清理后的安全路径
     */
    private function validatePath($path)
    {
        if (empty($path)) {
            return '';
        }
        
        // 1. 移除所有危险字符
        $path = str_replace(['..', '\\', "\0", '<', '>', '|', '&', ';'], '', $path);
        
        // 2. 字符白名单验证（只允许字母、数字、下划线、连字符、斜杆、点）
        if (!preg_match('#^[a-zA-Z0-9_\-/.]+$#', $path)) {
            return '';
        }
        
        // 3. 移除连续的斜杆
        $path = preg_replace('#/{2,}#', '/', $path);
        
        return $path;
    }
    
    /**
     * 安全函数：验证文件名，防止路径穿越
     * @param string $filename 待验证的文件名
     * @return string 清理后的安全文件名
     */
    private function validateFilename($filename)
    {
        if (empty($filename)) {
            return '';
        }
        
        // 1. 移除所有危险字符
        $filename = str_replace(['..', '/', '\\', "\0", '<', '>', '|', '&', ';'], '', $filename);
        
        // 2. 字符白名单验证（只允许字母、数字、下划线、连字符、点）
        if (!preg_match('#^[a-zA-Z0-9_\-\.]+$#', $filename)) {
            return '';
        }
        
        return $filename;
    }
    
    /**
     * 安全函数：检查是否为禁止编辑的系统关键文件
     * @param string $filename 待检查的文件名
     * @return bool true=允许编辑, false=禁止编辑
     */
    private function checkForbiddenFile($filename)
    {
        if (empty($filename)) {
            return false;
        }
        
        // 1. 禁止编辑的文件名列表（不区分大小写）
        $forbidden_files = [
            // 核心配置文件（实际存在）
            'config.php',           // 各模块配置
            'database.php',         // 数据库配置
            'route.php',            // 路由配置
            'tags.php',             // 标签配置
            'html.php',             // 静态生成配置
            '.htaccess',            // Apache配置
            
            // 系统入口文件（实际存在）
            'index.php',            // 前台入口
            'login.php',            // 后台登录入口
            'console.php',          // 控制台入口
            
            // 系统核心文件（实际存在）
            'common.php',           // 公共函数
            'function.php',         // 扩展函数
            'helper.php',           // 助手函数
            'start.php',            // 框架启动
            'base.php',             // 基础配置
            'convention.php',       // 惯例配置
            
            // 命令和自动化
            'command.php',          // 命令配置
            'auto.php',             // 安装器自动化
            
            // 第三方库配置
            'autoload.php',         // Composer自动加载
            'composer.json',        // Composer配置
        ];
        
        // 2. 转换为小写进行比较
        $filename_lower = strtolower($filename);
        
        // 3. 检查是否在禁止列表中
        foreach ($forbidden_files as $forbidden) {
            if ($filename_lower === strtolower($forbidden)) {
                return false; // 禁止编辑
            }
        }
        
        // 4. 禁止编辑所有 .php 文件（最重要的安全措施）
        $file_ext = pathinfo($filename_lower, PATHINFO_EXTENSION);
        if ($file_ext === 'php') {
            return false; // 禁止编辑所有 PHP 文件
        }
        
        // 5. 禁止编辑隐藏文件（以 . 开头）
        if (strpos(basename($filename), '.') === 0) {
            return false;
        }
        
        // 6. 禁止编辑数据库文件
        $db_extensions = ['sql', 'db', 'sqlite', 'mdb'];
        if (in_array($file_ext, $db_extensions)) {
            return false;
        }
        
        return true; // 允许编辑
    }
}
