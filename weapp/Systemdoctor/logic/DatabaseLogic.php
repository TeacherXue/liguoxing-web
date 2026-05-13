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

class DatabaseLogic extends Model
{
    /**
     * 析构函数
     */
    function  __construct() {

    }

    /**
     * 重新生成全部数据表缓存字段文件
     */
    public function schemaAllTable()
    {
        if (function_exists('schemaAllTable')) {
            schemaAllTable();
        } else {
            $dbtables = \think\Db::query('SHOW TABLE STATUS');
            $tableList = [];
            foreach ($dbtables as $k => $v) {
                if (preg_match('/^'.PREFIX.'/i', $v['Name'])) {
                    /*调用命令行的指令*/
                    \think\Console::call('optimize:schema', ['--table', $v['Name']]);
                    /*--end*/
                }
            }
        }
    }

    public function sql_split($sql, $tablepre) {
        /*从数据库文件，提取数据库文件里的表前缀*/
        $prefix = 'ey_';
        preg_match_all('/CREATE\s*TABLE\s*`([^`]+)\s*/', $sql, $matches2);
        $datatableList = !empty($matches2[1]) ? $matches2[1] : []; // 数据库所有表名
        if (!empty($datatableList)) {
            foreach ($datatableList as $key => $val) {
                if (preg_match('/_admin$/i', $val)) {
                    $prefix = preg_replace('/_admin$/i', '', $val).'_';
                    break;
                }
            }
        }
        /*--end*/

        if ($tablepre != $prefix) {
            $sql = str_replace('`'.$prefix, '`'.$tablepre, $sql);
        }
              
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)((\s+)DEFAULT(\s+)CHARSET=[^; ]+)?/i", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);
        
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $ret[$num] = rtrim($ret[$num], ';').';';
            $num++;
        }
        return $ret;
    }
}
