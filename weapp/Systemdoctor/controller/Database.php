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
use weapp\Systemdoctor\logic\DatabaseLogic;

/**
 * 插件的控制器
 */
class Database extends Base
{
    public $databaseLogic;

    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        $this->databaseLogic = new DatabaseLogic;
    }

    public function index()
    {
        return $this->fetch('database/index');
    }

    /**
     * 检测当前版本的数据库是否与官方一致
     */
    public function check_table()
    {
        if (IS_AJAX_POST) {
            /*------------------检测目录读写权限----------------------*/
            $values = [
                'version' => getCmsVersion(),
            ];
            $service_ey = 'aHR0cHM6Ly9zZXJ2aWNlLjVmYS5jbg==';
            $url = base64_decode($service_ey);
            if (stristr('https://', request()->scheme().':')) {
                $url = str_replace('http://', 'https://', $url);
            } else {
                $url = str_replace('https://', 'http://', $url);
            }
            $url .= '/index.php?m=api&c=Service&a=get_database_file';
            $response = @httpRequest($url, 'POST', $values, [], 5);
            if (false === $response) {
                $url = $url.'&'.http_build_query($values);
                $context = stream_context_set_default(array('http' => array('timeout' => 5,'method'=>'GET')));
                $response = @file_get_contents($url, false, $context);
            }
            $params = json_decode($response,true);
            if (false == $params) {
                $this->error('连接升级服务器超时，请刷新重试！', null, ['code'=>2]);
            }

            if (is_array($params)) {
                if (1 == intval($params['code'])) {
                    try {
                        $this->databaseLogic->schemaAllTable(); // 重新生成全部数据表字段缓存文件
                    } catch (\Exception $e) {}

                    /*------------------组合本地数据库信息----------------------*/
                    $dbtables       = Db::query('SHOW TABLE STATUS');
                    $local_database = array();
                    foreach ($dbtables as $k => $v) {
                        $table = $v['Name'];
                        if (preg_match('/^' . PREFIX . '/i', $table) && !preg_match('/^' . PREFIX . 'weapp_/i', $table)) {
                            // 读取缓存
                            $schema = preg_replace('/^'.PREFIX.'/i', 'ey_', $table); // 以表名做为文件名 by 小虎哥
                            if (is_file(DATA_PATH . 'schema/' . $schema . '.php')) {
                                $column_arr = include DATA_PATH . 'schema/' . $schema . '.php'; // 修改表字段文件路径  by 小虎哥
                                $column_arr = get_arr_column($column_arr, 'name');
                            } else {
                                $column_arr = Db::getTableFields($table);
                            }
                            if (empty($column_arr)) {
                                $column_arr = Db::query("SHOW COLUMNS FROM {$table}");
                                $column_arr = get_arr_column($column_arr, 'Field');
                            }
                            $local_database[$table] = [
                                'name'  => $table,
                                'field' => $column_arr,
                            ];
                        }
                    }
                    /*------------------end----------------------*/

                    $eyinfo      = base64_decode($params['info']);
                    $eytables    = base64_decode($params['tables']);
                    $eycolumns   = base64_decode($params['columns']);
                    $eymax_info  = base64_decode($params['max_info']); // 当前最大版本号的数据库结构
                    if (empty($eyinfo)) {
                        $this->error('获取服务器数据结构失败，请联系官方技术', null, ['code' => 2]);
                    }

                    /*------------------组合官方远程数据库信息----------------------*/
                    $eyinfo      = preg_replace("#[\r\n]{1,}#", "\n", $eyinfo);
                    $eyinfos     = explode("\n", $eyinfo);
                    $eyinfolists = [];
                    foreach ($eyinfos as $key => $val) {
                        if (!empty($val)) {
                            $arr                = explode('|', $val);
                            $eyinfolists[$arr[0]] = $val;
                        }
                    }

                    $eymax_info      = preg_replace("#[\r\n]{1,}#", "\n", $eymax_info);
                    $eymax_infos     = explode("\n", $eymax_info);
                    $eymax_infolists = [];
                    foreach ($eymax_infos as $key => $val) {
                        if (!empty($val)) {
                            $arr                = explode('|', $val);
                            $eymax_infolists[$arr[0]] = $val;
                        }
                    }
                    /*------------------end----------------------*/

                    /*------------------校验数据库是否合格----------------------*/
                    $error = "";
                    //对比多余的表
                    foreach ($local_database as $key => $val) {
                        $table = $val['name'];
                        if (!empty($eymax_infolists[$table]) && empty($eyinfolists[$table])) {
                            $error .= "<p>{$table} 数据表多余。</p>";
                            continue;
                        }
                    }
                    // 对比数据表字段数量
                    foreach ($eyinfolists as $k1 => $v1) {
                        $arr1 = explode('|', $v1);
                        if (1 >= count($arr1)) {
                            continue; // 忽略不对比的数据表
                        }

                        $fieldArr = explode(',', $arr1[1]);
                        $table    = preg_replace('/^ey_/i', PREFIX, $arr1[0]);
                        //对比缺少的表
                        if (empty($local_database[$table])) {
                            $error .= "<p>{$table} 数据表丢失。</p>";
                            continue;
                        }
                        //对比缺少的字段
                        $local_fields = $local_database[$table]['field'];
                        $diff_fields = array_diff($fieldArr, $local_fields);
                        if (!empty($diff_fields)) {
                            $err_field = '';
                            foreach ($fieldArr as $k2 => $v2) {
                                if (!in_array($v2, $local_fields)) {
                                    $err_field .= $v2 . ' 、';
                                }
                            }
                            if (!empty($err_field)) {
                                $error .= "<p>{$table} 数据表丢失字段 ".trim($err_field, ' 、')."。</p>";
                            }
                        }
                        //对比多余的字段
                        $arr2 = explode('|', $eymax_infolists[$k1]);
                        $fieldArr2 = explode(',', $arr2[1]);
                        $local_fields = $local_database[$table]['field'];
                        $diff_fields = array_diff($local_fields, $fieldArr);
                        if (!empty($diff_fields)) {
                            $err_field = '';
                            foreach ($diff_fields as $k2 => $v2) {
                                if (in_array($v2, $fieldArr2)) {
                                    $err_field .= $v2 . ' 、';
                                }
                            }
                            if (!empty($err_field)) {
                                $error .= "<p>{$table} 数据表多余字段 ".trim($err_field, ' 、')."。</p>";
                            }
                        }
                    }
                    if ($error != '') {
                        $error = "<p style='color:red;'>检测到以下数据表有缺陷，导致系统存在一些升级等未知问题，请先修复再升级系统。</p>".$error;
                        $this->error($error, null, ['code' => 2]);
                    } else {
                        $this->success('检测通过!');
                    }
                    /*------------------end----------------------*/
                } else if (2 == intval($params['code'])) {
                    $this->error('官方缺少版本号' . getCmsVersion() . '的数据库比较文件，请第一时间联系技术支持！', null, ['code' => 2]);
                }
            }
        }
        /*------------------end----------------------*/
    }

    /**
     * 修正数据表结构
     */
    public function repair_table()
    {
        if (IS_AJAX_POST) {
            /*------------------检测目录读写权限----------------------*/
            $values = [
                'version' => getCmsVersion(),
            ];
            $service_ey = 'aHR0cHM6Ly9zZXJ2aWNlLjVmYS5jbg==';
            $url = base64_decode($service_ey);
            if (stristr('https://', request()->scheme().':')) {
                $url = str_replace('http://', 'https://', $url);
            } else {
                $url = str_replace('https://', 'http://', $url);
            }
            $url .= '/index.php?m=api&c=Service&a=get_database_file';
            $response = @httpRequest($url, 'POST', $values, [], 5);
            if (false === $response) {
                $url = $url.'&'.http_build_query($values);
                $context = stream_context_set_default(array('http' => array('timeout' => 5,'method'=>'GET')));
                $response = @file_get_contents($url, false, $context);
            }
            $params = json_decode($response,true);
            if (false == $params) {
                $this->error('连接升级服务器超时，请刷新重试！', null, ['code'=>2]);
            }

            if (is_array($params)) {
                if (1 == intval($params['code'])) {
                    try {
                        $this->databaseLogic->schemaAllTable(); // 重新生成全部数据表字段缓存文件
                    } catch (\Exception $e) {}

                    /*------------------组合本地数据库信息----------------------*/
                    $dbtables       = Db::query('SHOW TABLE STATUS');
                    $local_database = array();
                    foreach ($dbtables as $k => $v) {
                        $table = $v['Name'];
                        if (preg_match('/^' . PREFIX . '/i', $table) && !preg_match('/^' . PREFIX . 'weapp_/i', $table)) {
                            // 读取缓存
                            $schema = preg_replace('/^'.PREFIX.'/i', 'ey_', $table); // 以表名做为文件名 by 小虎哥
                            if (is_file(DATA_PATH . 'schema/' . $schema . '.php')) {
                                $column_arr = include DATA_PATH . 'schema/' . $schema . '.php'; // 修改表字段文件路径  by 小虎哥
                                $column_arr = get_arr_column($column_arr, 'name');
                            } else {
                                $column_arr = Db::getTableFields($table);
                            }
                            if (empty($column_arr)) {
                                $column_arr = Db::query("SHOW COLUMNS FROM {$table}");
                                $column_arr = get_arr_column($column_arr, 'Field');
                            }
                            $local_database[$table] = [
                                'name'  => $table,
                                'field' => $column_arr,
                            ];
                        }
                    }
                    /*------------------end----------------------*/

                    $eyinfo      = base64_decode($params['info']);
                    $eytables    = base64_decode($params['tables']);
                    $eycolumns   = base64_decode($params['columns']);
                    $eymax_info  = base64_decode($params['max_info']); // 当前最大版本号的数据库结构
                    if (empty($eyinfo) || empty($eytables) || empty($eycolumns) || empty($eymax_info)) {
                        $this->error('获取服务器数据结构失败，请联系官方技术', null, ['code' => 2]);
                    }

                    /*------------------组合官方远程数据库信息----------------------*/
                    $eyinfo      = preg_replace("#[\r\n]{1,}#", "\n", $eyinfo);
                    $eyinfos     = explode("\n", $eyinfo);
                    $eyinfolists = [];
                    foreach ($eyinfos as $key => $val) {
                        if (!empty($val)) {
                            $arr                = explode('|', $val);
                            $eyinfolists[$arr[0]] = $val;
                        }
                    }

                    $eymax_info      = preg_replace("#[\r\n]{1,}#", "\n", $eymax_info);
                    $eymax_infos     = explode("\n", $eymax_info);
                    $eymax_infolists = [];
                    foreach ($eymax_infos as $key => $val) {
                        if (!empty($val)) {
                            $arr                = explode('|', $val);
                            $eymax_infolists[$arr[0]] = $val;
                        }
                    }
                    /*------------------end----------------------*/

                    // 官方内置表sql
                    $eytablelists = $this->databaseLogic->sql_split($eytables, PREFIX);
                    foreach ($eytablelists as $key => $val) {
                        $val = trim($val);
                        $table_name = preg_replace('/^CREATE(\s+)TABLE(\s+)\`ey_([^`]+)\`(\s+)\((.*)$/i', PREFIX.'${3}', $val);
                        $eytablelists[$table_name] = $val;
                        unset($eytablelists[$key]);
                    }

                    // 官方内置表的新增字段sql
                    $eycolumns      = preg_replace("#[\r\n]{1,}#", "\n", $eycolumns);
                    $eycolumnlists     = explode("\n", $eycolumns);
                    foreach ($eycolumnlists as $key => $val) {
                        $val = trim($val);
                        $val = rtrim($val, ';').';';
                        $table_name = preg_replace('/^ALTER(\s+)TABLE(\s+)\`ey_([^`]+)\`(\s+)(.*)$/i', PREFIX.'${3}', $val);
                        $column_name = preg_replace('/^ALTER(\s+)TABLE(\s+)\`ey_([^`]+)\`(\s+)ADD(\s+)COLUMN(\s+)\`([^`]+)\`(\s+)(.*)$/i', '${7}', $val);
                        $val = preg_replace('/^(ALTER(\s+)TABLE(\s+))\`ey_([^`]+)\`(\s+)(.*)$/i', '${1}`'.PREFIX.'${4}`${5}${6}', $val);
                        $eycolumnlists["{$table_name}|{$column_name}"] = $val;
                        unset($eycolumnlists[$key]);
                    }

                    /*------------------修正数据库结构----------------------*/
                    $handle_sql = [];
                    //对比多余的表
                    foreach ($local_database as $key => $val) {
                        $table = $val['name'];
                        if (!empty($eymax_infolists[$table]) && empty($eyinfolists[$table])) {
                            $handle_sql[] = "DROP TABLE IF EXISTS `{$table}`;";
                            continue;
                        }
                    }
                    // 对比数据表字段数量
                    foreach ($eyinfolists as $k1 => $v1) {
                        $arr1 = explode('|', $v1);
                        if (1 >= count($arr1)) {
                            continue; // 忽略不对比的数据表
                        }

                        $fieldArr = explode(',', $arr1[1]);
                        $table    = preg_replace('/^ey_/i', PREFIX, $arr1[0]);
                        //对比缺少的表
                        if (empty($local_database[$table])) {
                            if (!empty($eytablelists[$table])) {
                                $handle_sql[] = $eytablelists[$table];
                            }
                            continue;
                        }
                        //对比缺少的字段
                        $local_fields = $local_database[$table]['field'];
                        $diff_fields = array_diff($fieldArr, $local_fields);
                        if (!empty($diff_fields)) {
                            foreach ($fieldArr as $k2 => $v2) {
                                if (!in_array($v2, $local_fields)) {
                                    $new_key = "{$table}|{$v2}";
                                    if (!empty($eycolumnlists[$new_key])) {
                                        $handle_sql[] = $eycolumnlists[$new_key];
                                    }
                                }
                            }
                        }
                        //对比多余的字段
                        $arr2 = explode('|', $eymax_infolists[$k1]);
                        $fieldArr2 = explode(',', $arr2[1]);
                        $local_fields = $local_database[$table]['field'];
                        $diff_fields = array_diff($local_fields, $fieldArr);
                        if (!empty($diff_fields)) {
                            foreach ($diff_fields as $k2 => $v2) {
                                if (in_array($v2, $fieldArr2)) {
                                    $handle_sql[] = "ALTER TABLE `{$table}` DROP COLUMN `{$v2}`;";
                                }
                            }
                        }
                    }
                    if (!empty($handle_sql)) {
                        $error_sql = [];
                        foreach ($handle_sql as $key => $sql) {
                            try {
                                $r = @Db::execute($sql);
                            } catch (\Exception $e) {
                                $r = false;
                            }
                            if ($r === false) {
                                $sql = str_replace('ENGINE=MyISAM', 'ENGINE=InnoDB', $sql);
                                $r = @Db::execute($sql);
                                if ($r === false) {
                                    $error_sql[] = $sql;
                                }
                            }
                        }
                        try {
                            $this->databaseLogic->schemaAllTable(); // 重新生成全部数据表字段缓存文件
                        } catch (\Exception $e) {}

                        if (empty($error_sql)) {
                            $this->success('已修正完成');
                        } else {
                            $this->error('修正失败，请重新检测并修正！', null, ['code' => 2, 'error_sql'=>$error_sql]);
                        }
                    } else {
                        $this->success('检测数据库结构没有异常！');
                    }
                    /*------------------end----------------------*/
                } else if (2 == intval($params['code'])) {
                    $this->error('官方缺少版本号' . getCmsVersion() . '的数据库比较文件，请第一时间联系技术支持！', null, ['code' => 2]);
                }
            }
        }
        /*------------------end----------------------*/
    }
}