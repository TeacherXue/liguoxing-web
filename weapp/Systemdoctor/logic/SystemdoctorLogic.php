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

class SystemdoctorLogic
{
    /**
     * 获取插件配置信息
     * @return [type] [description]
     */
    public function getConfData($code)
    {
        $row = Db::name('weapp_systemdoctor')->where('code',$code)->order('id asc')->find();
        if (!empty($row['data'])) {
            $row['data'] = json_decode($row['data'], true);
        } else {
            $row['data'] = [];
        }

        return $row;
    }

    /**
     * 自定义函数递归的复制带有多级子目录的目录
     * 递归复制文件夹
     *
     * @param type $src 原目录
     * @param type $dst 复制到的目录
     * @param type $ignore_files 忽略的文件名
     */
    //参数说明：            
    //自定义函数递归的复制带有多级子目录的目录
    public function recurse_copy($src, $dst, $ignore_files = [])
    {
        $now = getTime();
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== $file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file, $ignore_files);
                } else {
                    if (file_exists($dst . DIRECTORY_SEPARATOR . $file)) {
                        if (!is_writeable($dst . DIRECTORY_SEPARATOR . $file)) {
                            return '网站目录没有写入权限，请调整权限';
                        }
                    }
                    $src_cy = $src . DIRECTORY_SEPARATOR . $file;
                    $dst_cy = $dst . DIRECTORY_SEPARATOR . $file;
                    $dst_tmp = str_ireplace('\\', '/', $dst_cy);
                    $is_copy = true;
                    foreach ($ignore_files as $key => $val) {
                        if (stristr($dst_tmp, $val)) {
                            $is_copy = false;
                            break;
                        }
                    }
                    if ($is_copy) {
                        $copyrt = @copy($src_cy, $dst_cy);
                        if (!$copyrt) {
                            return '网站目录没有写入权限，请调整权限';
                        }
                    }
                }
            }
        }
        closedir($dir);

        return true;
    }

    public function second_funclist()
    {
        $arr = [
            'Weapp@Systemdoctor/Filetool/*',
            'Weapp@Systemdoctor/Systemdoctor/restoreUpload',
            'Weapp@Systemdoctor/Systemdoctor/sql_command',
            'Weapp@Systemdoctor/Systemdoctor/sql_details',
            'Weapp@Systemdoctor/Systemdoctor/run_sql',
            'Weapp@Systemdoctor/Systemdoctor/data_replace_index',
            'Weapp@Systemdoctor/Systemdoctor/getTableField',
            'Weapp@Systemdoctor/Systemdoctor/th',
            'Weapp@Systemdoctor/Systemdoctor/filemanager_index',
            'Weapp@Systemdoctor/Systemdoctor/filemanager_replace_img',
            'Weapp@Systemdoctor/Systemdoctor/filemanager_newfile',
            'Weapp@Systemdoctor/Systemdoctor/filemanager_edit',
            'Weapp@Systemdoctor/Systemdoctor/trojan_horse',
        ];

        if (getVersion() < 'v1.6.8') {
            $arr = [];
        }

        return $arr;
    }

    /**
     * 是否需要密保验证，0=否，1=是
     */
    public function is_security_check()
    {
        $is_security_check = 1;
        $second_funclist = $this->second_funclist();
        if (!empty($second_funclist)) {
            $security = tpSetting('security');
            $admin_id = session('?admin_id') ? (int)session('admin_id') : 0;
            $admin_info = Db::name('admin')->field('admin_id,last_ip')->where(['admin_id'=>$admin_id])->find();
            // 当前管理员二次安全验证过的IP地址
            $security_answerverify_ip = !empty($security['security_answerverify_ip']) ? $security['security_answerverify_ip'] : '-1';
            // 同IP不验证
            if ($admin_info['last_ip'] == $security_answerverify_ip) {
                $is_security_check = 0;
            }
        } else {
            $is_security_check = 0;
        }

        return $is_security_check;
    }

    /**
     * 只保留指定天数的操作日志
     */
    public function del_adminlog()
    {
        try {
            $row = $this->getConfData('admin_log');
            if (!isset($row['data']['day'])) $row['data']['day'] = 30;

            if (!empty($row['data']['day'])) {
                $mtime = strtotime("-{$row['data']['day']} day");
                Db::name('admin_log')->where([
                    'log_time'  => ['lt', $mtime],
                    ])->delete();
            } else {
                Db::name('admin_log')->where([
                        'log_id'  => ['gt', 0],
                    ])->delete();
            }
        } catch (\Exception $e) {}
    }
}
