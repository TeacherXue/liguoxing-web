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

use think\Db;
use think\Model;
use weapp\Systemdoctor\logic\SystemdoctorLogic;

class BomLogic
{
    public $systemdoctorLogic;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->systemdoctorLogic = new SystemdoctorLogic;
    }

    /**
     * 获取前台模板所在路径
     * @return [type] [description]
     */
    public function get_tpl_path()
    {
        $tpl_theme = tpCache('web.web_tpl_theme');
        
        if (empty($tpl_theme)) {
            if (file_exists(ROOT_PATH.'template/default')) {
                $tpl_theme = 'default';
            } else {
                $tpl_theme = '';
            }
        } else {
            if ('default' == $tpl_theme && !file_exists(ROOT_PATH.'template/default')) {
                $tpl_theme = '';
            }
        }
        $tpl_theme = TEMPLATE_PATH.$tpl_theme;

        return $tpl_theme;
    }

    /**
     * 递归读取文件夹文件
     */
    public function bom_getDirFile($directory, $dir_name = '', &$arr_file = array(), &$total = 0)
    {
        $mydir = dir($directory);
        while ($file = $mydir->read()) {
            if ((is_dir("$directory/$file")) && !in_array($file, ['.','..','uploads'])) {
                if ($dir_name) {
                    $this->bom_getDirFile("$directory/$file", "$dir_name/$file", $arr_file, $total);
                } else {
                    $this->bom_getDirFile("$directory/$file", "$file", $arr_file, $total);
                }
            } else {
                if (!in_array($file, ['.','..']) && !preg_match('/(\\\|\/)bom_backup(\\\|\/)/i', $dir_name.'/')) {
                    $total +=1;
                    if ($dir_name) {
                        $arr_file[] = "$dir_name/$file";
                    } else {
                        $arr_file[] = "$file";
                    }
                } 
            } 
        }
        $mydir->close();

        return $arr_file;
    }

    public function getConfData()
    {
        $row = $this->systemdoctorLogic->getConfData('bom');
        if (!isset($row['data']['is_autoclear'])) $row['data']['is_autoclear'] = 0;
        if (!isset($row['data']['is_backup'])) $row['data']['is_backup'] = 1;

        return $row['data'];
    }

    /**
     * 去除bom头部信息
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public function rewrite($filename, $confData = []) {
        // 清理前备份
        if (!empty($confData['is_backup'])) {
            $bak_filename = str_replace('template', 'template'.DS.'bom_backup'.DS.date('Y-m-d'), $filename);
            tp_mkdir(dirname($bak_filename));
            @copy($filename, $bak_filename);
        }

        $fp      = fopen($filename, 'r');
        $content = fread($fp, filesize($filename));
        fclose($fp);

        $data = substr($content, 3);
        $fp = fopen($filename, "w");
        flock($fp, LOCK_EX);
        fwrite($fp, $data);
        fclose($fp);
    }

    /**
     * 是否是带bom头部信息
     * @param  string $buffer [description]
     * @return [type]         [description]
     */
    public function bom_checkCode($filename, $confData = [], &$num = 0) {
        $contents = file_get_contents($filename);
        $charset[1] = substr($contents, 0, 1);
        $charset[2] = substr($contents, 1, 1);
        $charset[3] = substr($contents, 2, 1);
        if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
            $num++;
            if (!empty($confData['is_autoclear'])) {
                $this->rewrite($filename, $confData);
                return [
                    'code'  => 0,
                    'msg'   => "<font color=red>发现bom头部信息</font>",
                ];
            } else {
                return [
                    'code'  => 0,
                    'msg'   => "<font color=red>发现bom头部信息</font>",
                ];
            }
        } else {
            return [
                'code'  => 1,
                'msg'   => "未发现bom头部信息",
            ];
        }

        return $data;
    }
}
