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

namespace weapp\Systemdoctor\logic;

use think\Model;
use think\db;
/**
 * 文件管理逻辑定义
 * Class CatsLogic
 * @package admin\Logic
 */
class FiletoolLogic extends Model
{
    public $globalTpCache = array();
    public $baseDir = ''; // 服务器站点根目录绝对路径
    public $maxDir = '';
    public $replaceImgOpArr = array(); // 替换权限
    public $editOpArr = array(); // 编辑权限
    public $renameOpArr = array(); // 改名权限
    public $delOpArr = array(); // 删除权限
    public $moveOpArr = array(); // 移动权限
    public $editExt = array(); // 允许新增/编辑扩展名文件
    public $disableFuns = array(); // 允许新增/编辑扩展名文件

    /**
     * 析构函数
     */
    function  __construct() {
        $this->globalTpCache = tpCache('global');
        $this->baseDir = rtrim(ROOT_PATH, DS); // 服务器站点根目录绝对路径
        $this->maxDir = ''; // 默认文件管理的最大级别目录
        // 替换权限
        $this->replaceImgOpArr = array('gif','jpg','svg','jpeg','bmp','webp','png');
        // 编辑权限
        $this->editOpArr = array('txt','inc','pl','cgi','asp','xml','xsl','aspx','cfm','htm','html','php','js','css');
        // 改名权限
        // $this->renameOpArr = array('dir','gif','jpg','svg','flash','zip','exe','mp3','wmv','rm','txt','htm','js','css','other');
        // 删除权限
        // $this->delOpArr = array('dir','gif','jpg','svg','flash','zip','exe','mp3','wmv','rm','txt','htm','php','js','css','other');
        // 移动权限
        // $this->moveOpArr = array('gif','jpg','svg','flash','zip','exe','mp3','wmv','rm','txt','htm','js','css','other');
        // 允许新增/编辑扩展名文件
        $this->editExt = array_merge($this->editOpArr,['htaccess']);
        // 过滤php危险函数
        $this->disableFuns = ['phpinfo'];
    }

    /**
     * 编辑文件
     *
     * @access    public
     * @param     string  $filename  文件名
     * @param     string  $activepath  当前路径
     * @param     string  $content  文件内容
     * @return    string
     */
    public function editFile($filename, $activepath = '', $content = '')
    {
        // 文件名安全检查
        $fileinfo = pathinfo($filename);
        $ext = strtolower($fileinfo['extension']);
        $filename = $this->safeFileName(trim($fileinfo['filename'], '.').'.'.$fileinfo['extension']);
        
        if (!$filename) {
            return '文件名含有不安全的字符或扩展名';
        }

        /*不允许越过指定最大级目录的文件编辑*/
        $activepath = $this->safeActivePath($activepath);
        if ($activepath === false) {
            return '没有操作权限！';
        }
        /*--end*/

        /*允许编辑的文件类型*/
        $safeEditExt = $this->editExt; // ['txt', 'htm', 'html', 'css', 'js', 'xml', 'htaccess'];
        if (!in_array($ext, $safeEditExt)) {
            return '只允许操作文件类型如下：'.implode('|', $safeEditExt);
        }
        /*--end*/

        $file = $this->baseDir."$activepath/$filename";
        
        // 使用realpath确保路径安全
        $real_file = realpath(dirname($file));
        $real_base = realpath($this->baseDir.$this->maxDir);
        
        if (!$real_file || strpos($real_file, $real_base) !== 0) {
            return '文件路径不合法，可能存在安全风险';
        }
        
        if (!is_writable(dirname($file))) {
            return "请把模板文件目录设置为可写入权限！";
        }
        
        // 根据文件类型采取不同的安全措施
        if (in_array($ext, ['htm', 'html'])) {
            $content = htmlspecialchars_decode($content, ENT_QUOTES);
            
            // 检查危险内容
            if ($this->containsDangerousCode($content)) {
                return "模板里不允许包含PHP代码或危险的脚本代码，为了安全考虑，请通过FTP工具进行编辑上传。";
            }
            
            // 对特定函数名进行转义处理
            foreach ($this->disableFuns as $key => $val) {
                $val_new = msubstr($val, 0, 1).'-'.msubstr($val, 1);
                $content = preg_replace("/(@)?".$val."(\s*)\(/i", "{$val_new}(", $content);
            }
        }
        
        $fp = fopen($file, "w");
        fputs($fp, $content);
        fclose($fp);
        
        return true;
    }

    /**
     * 检查内容是否包含危险代码
     */
    private function containsDangerousCode($content)
    {
        // 检查PHP代码
        $php_patterns = [
            '/<([^?]*)\?php/i',    // <?php 标签
            '/<\?(\s*)=/i',         // <?= 标签
            '/<\?/i',               // <? 短标签
            '/\?>/i',               // 结束标签
            '/\{eyou\:php([^\}]*)\}/i', // {eyou:php} 标签
            '/\{php([^\}]*)\}/i',   // {php} 标签
            '/ev'.'al\s*\(/i',         // eval() 函数
            '/sys'.'tem\s*\(/i',       // system() 函数
            '/ex'.'ec\s*\(/i',         // exec() 函数
            '/sh'.'ell_ex'.'ec\s*\(/i',   // shell_exec() 函数
            '/pas'.'sthru\s*\(/i',     // passthru() 函数
            '/ass'.'ert\s*\(/i',       // assert() 函数
            '/pre'.'g_re'.'place\s*\(.+\/e/i', // preg_replace() with /e modifier
            '/crea'.'te_func'.'tion\s*\(/i', // 危险() 函数
            '/incl'.'ude\s*\(/i',      // include() 函数
            '/req'.'uire\s*\(/i',      // require() 函数
            '/includ'.'e_once\s*\(/i', // include_once() 函数
            '/requir'.'e_once\s*\(/i', // require_once() 函数
            '/\$_(GET|POST|REQUEST|COOKIE|SERVER|SESSION|ENV|FILES)\s*\[/i', // 全局变量
        ];
        
        // 检查危险的JavaScript代码
        $js_patterns = [
            '/on(error|load|mouse|key|touch|abort|beforeunload|hashchange|message|offline|online|pagehide|pageshow|popstate|resize|storage|unload)\s*=/i', // 事件处理程序
            '/vbscript\s*:/i',      // vbscript: 协议
            '/data\s*:[^,]*base64/i', // 基于base64的data: URI
        ];
        
        // 合并所有模式
        $patterns = array_merge($php_patterns, $js_patterns);
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * 上传文件
     *
     * @param     string  $dirname  新目录
     * @param     string  $activepath  当前路径
     * @param     boolean  $replace  是否替换
     * @param     string  $type  文件类型：图片image , 附件file , 视频media
     */
    public function upload($fileElementId, $activepath = '', $replace = false, $type = 'image')
    {
        $retData = [];
        $file = request()->file($fileElementId);
        if (is_object($file) && !is_array($file)) {
            $retData = $this->uploadfile($file, $activepath, $replace, $type);
        } 
        else if (!is_object($file) && is_array($file)) {
            $fileArr = $file;
            $i = 0;
            $j = 0;
            foreach ($fileArr as $key => $fileObj) {
                if (empty($fileObj)) {
                    continue;
                }
                $res = $this->uploadfile($fileObj, $activepath, $replace, $type);
                if(!empty($res['code']) && $res['code'] == 1) {
                    $i++;
                } else {
                    $j++;
                }
            }

            if ($j == 0) {
                $retData['code'] = 0;
                $retData['msg'] = "上传失败 $i 个文件到: $activepath";
            } else {
                $retData['code'] = 1;
                $retData['msg'] = "上传成功！";
            }
        }

        return $retData;
    }

    /**
     * 自定义上传
     *
     * @param     object  $file  文件对象
     * @param     string  $activepath  当前路径
     * @param     boolean  $replace  是否替换
     * @param     string  $type  文件类型：图片image , 附件file , 视频media
     */
    public function uploadfile($file, $activepath = '', $replace = false, $type = 'image')
    {
        $validate = array();

        /*文件类型限制*/
        switch ($type) {
            case 'image':
                $validate_ext = tpCache('basic.image_type');
                break;

            case 'file':
                $validate_ext = tpCache('basic.file_type');
                break;

            case 'media':
                $validate_ext = tpCache('basic.media_type');
                break;
            
            default:
                $validate_ext = tpCache('basic.image_type');
                break;
        }
        $validate['ext'] = explode('|', $validate_ext);
        /*--end*/

        /*文件大小限制*/
        $validate_size = tpCache('basic.file_size');
        if (!empty($validate_size)) {
            $validate['size'] = $validate_size * 1024 * 1024; // 单位为b
        }
        /*--end*/

        /*上传文件验证*/
        if (!empty($validate)) {
            $is_validate = $file->check($validate);
            if ($is_validate === false) {
                return ['code'=>0, 'msg'=>$file->getError()];
            }   
        }
        /*--end*/

        // 进一步验证上传的文件路径安全性
        $activepath = $this->safeActivePath($activepath);
        if ($activepath === false) {
            return ['code'=>0, 'msg'=>'非法的上传路径'];
        }

        $savePath = !empty($activepath) ? trim($activepath, '/') : UPLOAD_PATH.'temp';
        if (!file_exists($savePath)) {
            tp_mkdir($savePath);
        }

        if (false == $replace) {
            $fileinfo = $file->getInfo();
            $filename = pathinfo($fileinfo['name'], PATHINFO_BASENAME); //获取上传文件名
            // $org_filename = pathinfo($fileinfo['name'], PATHINFO_BASENAME); //获取上传文件名
            // 生成随机文件名，不使用原始文件名
            // $filename = dd2char(date("ymdHis").mt_rand(100,999)) . '.' . pathinfo($org_filename, PATHINFO_EXTENSION);
        } else {
            // 使用安全过滤后的文件名
            $filename = $this->safeFileName($replace);
        }

        $fileExt = pathinfo($filename, PATHINFO_EXTENSION); //获取上传文件扩展名
        $fileExt = strtolower($fileExt); // 转为小写
        if (!in_array($fileExt, $validate['ext'])) {
            return ['code'=>0, 'msg'=>'上传文件后缀不允许'];
        }

        // 图片类型文件的二次检测
        if ($type == 'image') {
            $tmp_name = $file->getInfo('tmp_name');
            if (!$this->isRealImage($tmp_name, $fileExt)) {
                return ['code'=>0, 'msg'=>'上传的文件不是有效的图片文件'];
            }
        }

        // 使用自定义的文件保存规则
        $info = $file->move($savePath, $filename, true);
        if($info){
            return ['code'=>1, 'msg'=>'上传成功'];
        }else{
            return ['code'=>0, 'msg'=>$file->getError()];
        }
    }

    /**
     * 安全过滤上传路径
     */
    private function safeActivePath($activepath)
    {
        // 防止目录遍历
        $activepath = str_replace(['..', '\\', ':', '?', '*', '|', '<', '>', '"', "'"], '', $activepath);
        $activepath = preg_replace('#/{2,}#', '/', $activepath); // 多个斜杠替换为单个斜杠
        
        // 检查是否越权访问了系统目录
        $tmp_max_dir = preg_replace("#\/#i", "\/", $this->maxDir);
        if (!preg_match("#^".$tmp_max_dir."#i", $activepath)) {
            return false;
        }
        
        return $activepath;
    }

    /**
     * 安全过滤文件名
     */
    private function safeFileName($filename)
    {
        // 只保留文件名中的安全字符
        $filename = preg_replace('/[^a-zA-Z0-9\-\_\.]/', '', $filename);
        
        // 检查扩展名安全性
        $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
        $fileExt = strtolower($fileExt);
        
        // 禁止上传可执行文件
        $dangerousExts = ['php', 'php3', 'php4', 'php5', 'phtml', 'pht', 'asp', 'aspx', 'exe', 'sh'];
        if (in_array($fileExt, $dangerousExts)) {
            return false;
        }
        
        return $filename;
    }

    /**
     * 检查图片文件是否为真实图片
     */
    private function isRealImage($file, $ext)
    {
        // 使用exif_imagetype检查文件类型是否为图片
        if (function_exists('exif_imagetype')) {
            $imageType = exif_imagetype($file);
            if (!$imageType) {
                return false;
            }

            // 允许的图片类型
            $validImageTypes = [];
            if (defined('IMAGETYPE_GIF')) $validImageTypes[] = IMAGETYPE_GIF;
            if (defined('IMAGETYPE_JPEG')) $validImageTypes[] = IMAGETYPE_JPEG;
            if (defined('IMAGETYPE_PNG')) $validImageTypes[] = IMAGETYPE_PNG;
            if (defined('IMAGETYPE_SWF')) $validImageTypes[] = IMAGETYPE_SWF;
            if (defined('IMAGETYPE_PSD')) $validImageTypes[] = IMAGETYPE_PSD;
            if (defined('IMAGETYPE_BMP')) $validImageTypes[] = IMAGETYPE_BMP;
            if (defined('IMAGETYPE_TIFF_II')) $validImageTypes[] = IMAGETYPE_TIFF_II;
            if (defined('IMAGETYPE_TIFF_MM')) $validImageTypes[] = IMAGETYPE_TIFF_MM;
            if (defined('IMAGETYPE_JPC')) $validImageTypes[] = IMAGETYPE_JPC;
            if (defined('IMAGETYPE_JP2')) $validImageTypes[] = IMAGETYPE_JP2;
            if (defined('IMAGETYPE_JPX')) $validImageTypes[] = IMAGETYPE_JPX;
            if (defined('IMAGETYPE_JB2')) $validImageTypes[] = IMAGETYPE_JB2;
            if (defined('IMAGETYPE_SWC')) $validImageTypes[] = IMAGETYPE_SWC;
            if (defined('IMAGETYPE_IFF')) $validImageTypes[] = IMAGETYPE_IFF;
            if (defined('IMAGETYPE_WBMP')) $validImageTypes[] = IMAGETYPE_WBMP;
            if (defined('IMAGETYPE_XBM')) $validImageTypes[] = IMAGETYPE_XBM;
            if (defined('IMAGETYPE_ICO')) $validImageTypes[] = IMAGETYPE_ICO;
            if (defined('IMAGETYPE_WEBP')) $validImageTypes[] = IMAGETYPE_WEBP;
            if (defined('IMAGETYPE_AVIF')) $validImageTypes[] = IMAGETYPE_AVIF;
            
            return in_array($imageType, $validImageTypes);
        }
        
        // 如果exif_imagetype不可用，使用其他方法检测
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'ico'];
        if (!in_array($ext, $allowedExts)) {
            return false;
        }
        
        try {
            $image = @getimagesize($file);
            return $image !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 当前目录下的文件列表
     */
    public function getDirFile($directory, $activepath = '',  &$arr_file = array()) {

        if (!file_exists($directory)) {
            return false;
        }

        $fileArr = $dirArr = $parentArr = array();

        $mydir = dir($directory);
        while(false !== $file = $mydir->read())
        {
            $filesize = $filetime = $intro = '';
            $filemine = 'file';

            if($file != "." && $file != ".." && !is_dir("$directory/$file"))
            {
                @$filesize = filesize("$directory/$file");
                @$filesize = format_bytes($filesize);
                @$filetime = filemtime("$directory/$file");
            }

            if ($file == '.') 
            {
                continue;
            } 
            else if($file == "..") 
            {
                if($activepath == "" || $activepath == $this->maxDir) {
                    continue;
                }
                $parentArr = array(
                    array(
                        'filepath'  => preg_replace("#[\/][^\/]*$#i", "", $activepath),
                        'filename'  => '上级目录',
                        'filesize'  => '',
                        'filetime'  => '',
                        'filemine'  => 'dir',
                        'filetype'  => 'dir2',
                        'icon'      => 'file_topdir.gif',
                        'intro'  => '（当前目录：'.$activepath.'）',
                        'act'       => [],
                    ),
                );
                continue;
            } 
            else if(is_dir("$directory/$file"))
            {
                if(preg_match("#^_(.*)$#i", $file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
                if(preg_match("#^\.(.*)$#i", $file)) continue;
                $encoding = mb_detect_encoding($file,['UTF-8','GBK','BIG5','CP936']);
                $file = iconv($encoding,'UTF-8',$file); //转码
                $file_info = array(
                    'filepath'  => $activepath.'/'.$file,
                    'filename'  => $file,
                    'filesize'  => '',
                    'filetime'  => '',
                    'filemine'  => 'dir',
                    'filetype'  => 'dir',
                    'icon'      => 'dir.gif',
                    'intro'     => '',
                    'act'       => ['rename','del'],
                );
                array_push($dirArr, $file_info);
                continue;
            }
            else if(preg_match("#\.(gif|png)#i",$file))
            {
                $filemine = 'image';
                $filetype = 'gif';
                $icon = 'gif.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(jpg|jpeg|bmp|webp)#i",$file))
            {
                $filemine = 'image';
                $filetype = 'jpg';
                $icon = 'jpg.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(svg)#i",$file))
            {
                $filemine = 'image';
                $filetype = 'svg';
                $icon = 'jpg.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(swf|fla|fly)#i",$file))
            {
                $filetype = 'flash';
                $icon = 'flash.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(zip|rar|tar.gz)#i",$file))
            {
                $filetype = 'zip';
                $icon = 'zip.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(exe)#i",$file))
            {
                $filetype = 'exe';
                $icon = 'exe.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(mp3|wma)#i",$file))
            {
                $filetype = 'mp3';
                $icon = 'mp3.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(wmv|api)#i",$file))
            {
                $filetype = 'wmv';
                $icon = 'wmv.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(rm|rmvb)#i",$file))
            {
                $filetype = 'rm';
                $icon = 'rm.gif';
                $act = ['rename','del','move'];
            }
            else if(preg_match("#\.(txt|inc|pl|cgi|asp|xml|xsl|aspx|cfm)#",$file))
            {
                $filetype = 'txt';
                $icon = 'txt.gif';
                $act = ['edit','rename','del','move'];
            }
            else if(preg_match("#\.(htm|html)#i",$file))
            {
                $filetype = 'htm';
                $icon = 'htm.gif';
                $act = ['edit','rename','del','move'];
            }
            else if(preg_match("#\.(php)#i",$file))
            {
                $filetype = 'php';
                $icon = 'php.gif';
                $act = ['edit','rename','del','move'];
            }
            else if(preg_match("#\.(js)#i",$file))
            {
                $filetype = 'js';
                $icon = 'js.gif';
                $act = ['edit','rename','del','move'];
            }
            else if(preg_match("#\.(css)#i",$file))
            {
                $filetype = 'css';
                $icon = 'css.gif';
                $act = ['edit','rename','del','move'];
            }
            else
            {
                $filetype = 'other';
                $icon = 'other.gif';
                $act = ['rename','del','move'];
            }

            $encoding = mb_detect_encoding($file,['UTF-8','GBK','BIG5','CP936']);
            $file = iconv($encoding,'UTF-8',$file); //转码
            $file_info = array(
                'filepath'  => $activepath.'/'.$file,
                'filename'  => $file,
                'filesize'  => $filesize,
                'filetime'  => $filetime,
                'filemine'  => $filemine,
                'filetype'  => $filetype,
                'icon'      => $icon,
                'intro'     => $intro,
            );
            array_push($fileArr, $file_info);
        }
        $mydir->close();

        $arr_file = array_merge($parentArr, $dirArr, $fileArr);

        return $arr_file;
    }

    /**
     * 将冒号符反替换为反斜杠，适用于IIS服务器在URL上的双重转义限制
     * @param string $filepath 相对路径
     * @param string $replacement 目标字符
     * @param boolean $is_back false为替换，true为还原
     */
    public function replace_path($activepath, $replacement = ':', $is_back = false)
    {
        return replace_path($activepath, $replacement, $is_back);
    }

    /**
     * 删除目录
     *
     * @param unknown_type $indir
     */
    public function RmDirFiles($indir)
    {
        if(!is_dir($indir))
        {
            return ;
        }
        $dh = dir($indir);
        while($filename = $dh->read())
        {
            if($filename == "." || $filename == "..")
            {
                continue;
            }
            else if(is_file("$indir/$filename"))
            {
                @unlink("$indir/$filename");
            }
            else
            {
                $this->RmDirFiles("$indir/$filename");
            }
        }
        $dh->close();
        @rmdir($indir);
    }
}
