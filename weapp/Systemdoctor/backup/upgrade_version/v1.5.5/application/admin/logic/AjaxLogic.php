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

namespace app\admin\logic;

use think\Model;
use think\Db;

/**
 * 逻辑定义
 * Class CatsLogic
 * @package admin\Logic
 */
class AjaxLogic extends Model
{
    private $request = null;
    private $admin_lang = 'cn';
    private $main_lang = 'cn';

    /**
     * 析构函数
     */
    function  __construct() {
        $this->request = request();
        $this->admin_lang = get_admin_lang();
        $this->main_lang = get_main_lang();
    }

    /**
     * 进入登录页面需要异步处理的业务
     */
    public function login_handle()
    {
        $this->saveBaseFile(); // 存储后台入口文件路径，比如：/login.php
        clear_session_file(); // 清理过期的data/session文件
    }

    /**
     * 进入欢迎页面需要异步处理的业务
     */
    public function welcome_handle()
    {
        getVersion('version_themeusers', 'v1.0.1', true);
        getVersion('version_themeshop', 'v1.0.1', true);
        $this->saveBaseFile(); // 存储后台入口文件路径，比如：/login.php
        $this->renameInstall(); // 重命名安装目录，提高网站安全性
        $this->del_adminlog(); // 只保留最近一个月的操作日志
        // tpversion(); // 统计装载量，请勿删除，谢谢支持！
    }
    
    /**
     * 只保留最近一个月的操作日志
     */
    public function del_adminlog()
    {
        try {
            $mtime = strtotime("-1 month");
            Db::name('admin_log')->where([
                'log_time'  => ['lt', $mtime],
                ])->delete();
        } catch (\Exception $e) {}
    }

    /**
     * 重命名安装目录，提高网站安全性
     * 在 Admin@login 和 Index@index 操作下
     */
    private function renameInstall()
    {
        if (stristr($this->request->host(), 'eycms.hk')) {
            return true;
        }
        $install_path = ROOT_PATH.'install';
        if (is_dir($install_path) && file_exists($install_path)) {
            $install_time = DEFAULT_INSTALL_DATE;
            $constsant_path = APP_PATH.'admin/conf/constant.php';
            if (file_exists($constsant_path)) {
                require_once($constsant_path);
                defined('INSTALL_DATE') && $install_time = INSTALL_DATE;
            }
            $new_path = ROOT_PATH.'install_'.$install_time;
            @rename($install_path, $new_path);
        } else { // 修补v1.1.6版本删除的安装文件 install.lock
            if(!empty($_SESSION['isset_install_lock']))
                return true;
            $_SESSION['isset_install_lock'] = 1;

            $install_time = DEFAULT_INSTALL_DATE;
            $constsant_path = APP_PATH.'admin/conf/constant.php';
            if (file_exists($constsant_path)) {
                require_once($constsant_path);
                defined('INSTALL_DATE') && $install_time = INSTALL_DATE;
            }
            $filename = ROOT_PATH.'install_'.$install_time.DS.'install.lock';
            if (!file_exists($filename)) {
                @file_put_contents($filename, '');
            }
        }
    }

    /**
     * 存储后台入口文件路径，比如：/login.php
     * 在 Admin@login 和 Index@index 操作下
     */
    private function saveBaseFile()
    {
        $baseFile = $this->request->baseFile();
        /*多语言*/
        if (is_language()) {
            $langRow = \think\Db::name('language')->field('mark')->order('id asc')->select();
            foreach ($langRow as $key => $val) {
                tpCache('web', ['web_adminbasefile'=>$baseFile], $val['mark']);
            }
        } else { // 单语言
            tpCache('web', ['web_adminbasefile'=>$baseFile]);
        }
        /*--end*/
    }

    /**
     * 升级前台会员中心的模板文件
     */
    public function update_template($type = '')
    {
        if (!empty($type)) {
            if ('users' == $type) {
                if (file_exists(ROOT_PATH.'template/'.TPL_THEME.'pc/users') || file_exists(ROOT_PATH.'template/'.TPL_THEME.'mobile/users')) {
                    $upgrade = getDirFile(DATA_PATH.'backup'.DS.'tpl');
                    if (!empty($upgrade) && is_array($upgrade)) {
                        delFile(DATA_PATH.'backup'.DS.'template_www');
                        // 升级之前，备份涉及的源文件
                        foreach ($upgrade as $key => $val) {
                            $val_tmp = str_replace("template/", "template/".TPL_THEME, $val);
                            $source_file = ROOT_PATH.$val_tmp;
                            if (file_exists($source_file)) {
                                $destination_file = DATA_PATH.'backup'.DS.'template_www'.DS.$val_tmp;
                                tp_mkdir(dirname($destination_file));
                                @copy($source_file, $destination_file);
                            }
                        }

                        // 递归复制文件夹
                        $this->recurse_copy(DATA_PATH.'backup'.DS.'tpl', rtrim(ROOT_PATH, DS));
                    }
                    /*--end*/
                }
            }
        }
    }

    /**
     * 自定义函数递归的复制带有多级子目录的目录
     * 递归复制文件夹
     *
     * @param string $src 原目录
     * @param string $dst 复制到的目录
     * @return string
     */                        
    //参数说明：            
    //自定义函数递归的复制带有多级子目录的目录
    private function recurse_copy($src, $dst)
    {
        $planPath_pc = "template/".TPL_THEME."pc/";
        $planPath_m = "template/".TPL_THEME."mobile/";
        $dir = opendir($src);

        /*pc和mobile目录存在的情况下，才拷贝会员模板到相应的pc或mobile里*/
        $dst_tmp = str_replace('\\', '/', $dst);
        $dst_tmp = rtrim($dst_tmp, '/').'/';
        if (stristr($dst_tmp, $planPath_pc) && file_exists($planPath_pc)) {
            tp_mkdir($dst);
        } else if (stristr($dst_tmp, $planPath_m) && file_exists($planPath_m)) {
            tp_mkdir($dst);
        }
        /*--end*/

        while (false !== $file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $needle = '/template/'.TPL_THEME;
                    $needle = rtrim($needle, '/');
                    $dstfile = $dst . '/' . $file;
                    if (!stristr($dstfile, $needle)) {
                        $dstfile = str_replace('/template', $needle, $dstfile);
                    }
                    $this->recurse_copy($src . '/' . $file, $dstfile);
                }
                else {
                    if (file_exists($src . DIRECTORY_SEPARATOR . $file)) {
                        /*pc和mobile目录存在的情况下，才拷贝会员模板到相应的pc或mobile里*/
                        $rs = true;
                        $src_tmp = str_replace('\\', '/', $src . DIRECTORY_SEPARATOR . $file);
                        if (stristr($src_tmp, $planPath_pc) && !file_exists($planPath_pc)) {
                            continue;
                        } else if (stristr($src_tmp, $planPath_m) && !file_exists($planPath_m)) {
                            continue;
                        }
                        /*--end*/
                        $rs = @copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                        if($rs) {
                            @unlink($src . DIRECTORY_SEPARATOR . $file);
                        }
                    }
                }
            }
        }
        closedir($dir);
    }
    
    // 记录当前是多语言还是单语言到文件里
    public function system_langnum_file()
    {
        model('Language')->setLangNum();
    }

    /**
     * 同步内置模型内置的附加表字段
     */
    public function admin_logic_model_addfields()
    {
        // 修复部分用户的所有模型都不出现编辑器的问题
        $syn_admin_logic_video_addfields_2 = tpCache('syn.syn_admin_logic_video_addfields_2', [], 'cn');
        if (empty($syn_admin_logic_video_addfields_2)) {
            try{
                $total = Db::name('channelfield_bind')->where(['id'=>['gt', 0]])->count();
                if (1 == $total) {
                    $channel_id = 5;
                    $field_id = Db::name('channelfield')->where(['channel_id'=>$channel_id,'name'=>'content'])->value('id');
                    if (!empty($field_id)) {
                        $count = Db::name('channelfield_bind')->where(['field_id'=>['NEQ', $field_id]])->count();
                        if (empty($count)) {
                            Db::name('channelfield_bind')->where(['field_id'=>$field_id])->delete();
                            Db::name('channelfield')->where(['channel_id'=>$channel_id])->delete();
                        }
                    }
                }
            }catch(\Exception $e){}
            tpCache('syn', ['syn_admin_logic_video_addfields_2'=>1], 'cn');
        }

        // 内置视频模型的自定义字段
        $syn_admin_logic_video_addfields = tpCache('syn.syn_admin_logic_video_addfields', [], 'cn');
        if ($syn_admin_logic_video_addfields < 5) {
            try{
                $channel_id = 5;
                $result = Db::name('channelfield')->field('id,name,ifmain')->where(['channel_id'=>$channel_id])->getAllWithIndex('name');
                if (empty($result)) {
                    $fieldLogic = new \app\admin\logic\FieldLogic;
                    $fieldLogic->synChannelTableColumns($channel_id);
                    $result = Db::name('channelfield')->field('id,name,ifmain')->where(['channel_id'=>$channel_id])->getAllWithIndex('name');
                }

                $bindRow = Db::name('channelfield_bind')->field('field_id')->where(['typeid'=>0])->getAllWithIndex('field_id');
                if (!empty($bindRow)) {
                    $addData = [];
                    foreach ($result as $key => $val) {
                        if (empty($val['ifmain']) && empty($bindRow[$val['id']])) {
                            $addData[] = [
                                'typeid'      => 0,
                                'field_id'    => $val['id'],
                                'add_time'    => getTime(),
                                'update_time' => getTime(),
                            ];
                        }
                    }
                    !empty($addData) && model('ChannelfieldBind')->saveAll($addData);
                }
            }catch(\Exception $e){}
            tpCache('syn', ['syn_admin_logic_video_addfields'=>5], 'cn');
        }

        // 内置专题模型的自定义字段
        $syn_admin_logic_special_addfields = tpCache('syn.syn_admin_logic_special_addfields', [], 'cn');
        if ($syn_admin_logic_special_addfields < 5) {
            try{
                $channel_id = 7;
                $result = Db::name('channelfield')->field('id,name,ifmain')->where(['channel_id'=>$channel_id])->getAllWithIndex('name');
                if (empty($result)) {
                    $fieldLogic = new \app\admin\logic\FieldLogic;
                    $fieldLogic->synChannelTableColumns($channel_id);
                    $result = Db::name('channelfield')->field('id,name,ifmain')->where(['channel_id'=>$channel_id])->getAllWithIndex('name');
                }

                $bindRow = Db::name('channelfield_bind')->field('field_id')->where(['typeid'=>0])->getAllWithIndex('field_id');
                if (!empty($bindRow)) {
                    $addData = [];
                    foreach ($result as $key => $val) {
                        if (empty($val['ifmain']) && empty($bindRow[$val['id']])) {
                            $addData[] = [
                                'typeid'      => 0,
                                'field_id'    => $val['id'],
                                'add_time'    => getTime(),
                                'update_time' => getTime(),
                            ];
                        }
                    }
                    !empty($addData) && model('ChannelfieldBind')->saveAll($addData);
                }
            }catch(\Exception $e){}
            tpCache('syn', ['syn_admin_logic_special_addfields'=>5], 'cn');
        }
    }

    /**
     * 补充后台登录logo与背景图
     * @return [type] [description]
     */
    public function admin_logic_1608884981()
    {
        $syn_admin_logic_1608884981 = tpCache('syn.syn_admin_logic_1608884981', [], 'cn');
        if (empty($syn_admin_logic_1608884981)) {
            $web_adminlogo = Db::name('config')->where(['name'=>'web_adminlogo'])->value('value');
            $web_loginlogo = str_ireplace('logo', 'login-logo', $web_adminlogo);
            $web_loginbgimg = str_ireplace('logo', 'login-bg', $web_adminlogo);
            $web_loginbgimg = str_ireplace('.png', '.jpg', $web_adminlogo);
            $data = [
                'web_adminlogo' => $web_adminlogo,
                'web_loginlogo' => $web_loginlogo,
                'web_loginbgimg' => $web_loginbgimg,
            ];
            tpCache('web', $data);
            tpCache('syn', ['syn_admin_logic_1608884981'=>1], 'cn');
        }

        $syn_admin_logic_1608884981_2 = tpCache('syn.syn_admin_logic_1608884981_2', [], 'cn');
        if (empty($syn_admin_logic_1608884981_2)) {
            $source = realpath('public/static/admin/images/logo.png');
            $destination = realpath('public/static/admin/images/login-logo.png');
            @copy($source, $destination);
            
            tpCache('syn', ['syn_admin_logic_1608884981_2'=>1], 'cn');
        }
    }

    public function admin_logic_1609900642()
    {
        $vars1 = 'cGhwLnBo'.'cF9zZXJ2aW'.'NlaW5mbw==';
        $vars1 = base64_decode($vars1);
        $data = tpCache($vars1);
        $data = mchStrCode($data, 'DECODE');
        $data = json_decode($data, true);
        if (empty($data['pid']) || 2 > $data['pid']) return true;
        $file = "./data/conf/{$data['code']}.txt";
        $vars2 = 'cGhwX3Nl'.'cnZpY2V'.'tZWFs';
        $vars2 = base64_decode($vars2);
        if (!file_exists($file)) {
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('php', [$vars2=>1], $val['mark']);
                }
            } else { // 单语言
                tpCache('php', [$vars2=>1]);
            }
            /*--end*/
        } else {
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('php', [$vars2=>$data['pid']], $val['mark']);
                }
            } else { // 单语言
                tpCache('php', [$vars2=>$data['pid']]);
            }
            /*--end*/
        }
    }

    /**
     * 内置手机端会员中心底部菜单数据
     * @return [type] [description]
     */
    public function admin_logic_1610086647()
    {
        $admin_logic_1610086647 = tpCache('syn.admin_logic_1610086647', [], 'cn');
        if (empty($admin_logic_1610086647)) {
            try{
                /*多语言*/
                if (is_language()) {
                    $langRow = Db::name('language')->field('mark')->order('id asc')->select();
                    foreach ($langRow as $key => $val) {
                        $saveData = [
                            [
                            'title'    => '首页',
                            'mca'    => 'home/Index/index',
                            'icon'    => 'shouye',
                            'sort_order'    => 100,
                            'status'        => 1,
                            'display'        => 1,
                            'lang'          => $val['mark'],
                            'add_time'      => getTime(),
                            'update_time'   => getTime(),
                            ],
                            [
                                'title'    => '下载',
                                'mca'    => 'user/Download/index',
                                'icon'    => 'xiazai',
                                'sort_order'    => 100,
                                'status'        => 1,
                                'display'        => 1,
                                'lang'          => $val['mark'],
                                'add_time'      => getTime(),
                                'update_time'   => getTime(),
                            ],
                            [
                                'title'    => '发布',
                                'mca'    => 'user/UsersRelease/article_add',
                                'icon'    => 'fabu',
                                'sort_order'    => 100,
                                'status'        => 1,
                                'display'        => 1,
                                'lang'          => $val['mark'],
                                'add_time'      => getTime(),
                                'update_time'   => getTime(),
                            ],
                            [
                                'title'    => '我的',
                                'mca'    => 'user/Users/centre',
                                'icon'    => 'geren',
                                'sort_order'    => 100,
                                'status'        => 1,
                                'display'        => 1,
                                'lang'          => $val['mark'],
                                'add_time'      => getTime(),
                                'update_time'   => getTime(),
                            ],
                        ];
                        Db::name('users_bottom_menu')->insertAll($saveData);
                    }
                } else { // 单语言
                    $saveData = [
                        [
                            'title'    => '首页',
                            'mca'    => 'home/Index/index',
                            'icon'    => 'shouye',
                            'sort_order'    => 100,
                            'status'        => 1,
                            'display'        => 1,
                            'lang'          => get_main_lang(),
                            'add_time'      => getTime(),
                            'update_time'   => getTime(),
                        ],
                        [
                            'title'    => '下载',
                            'mca'    => 'user/Download/index',
                            'icon'    => 'xiazai',
                            'sort_order'    => 100,
                            'status'        => 1,
                            'display'        => 1,
                            'lang'          => get_main_lang(),
                            'add_time'      => getTime(),
                            'update_time'   => getTime(),
                        ],
                        [
                            'title'    => '发布',
                            'mca'    => 'user/UsersRelease/article_add',
                            'icon'    => 'fabu',
                            'sort_order'    => 100,
                            'status'        => 1,
                            'display'        => 1,
                            'lang'          => get_main_lang(),
                            'add_time'      => getTime(),
                            'update_time'   => getTime(),
                        ],
                        [
                            'title'    => '我的',
                            'mca'    => 'user/Users/centre',
                            'icon'    => 'geren',
                            'sort_order'    => 100,
                            'status'        => 1,
                            'display'        => 1,
                            'lang'          => get_main_lang(),
                            'add_time'      => getTime(),
                            'update_time'   => getTime(),
                        ],
                    ];
                    Db::name('users_bottom_menu')->insertAll($saveData);
                }
                /*--end*/
                tpCache('syn', ['admin_logic_1610086647'=>1], 'cn');
            }catch(\Exception $e){}
        }
    }

    /**
     * 内置余额支付开关，控制前台余额支付显示\隐藏 (v1.6.1节点去掉)
     * 于2021-01-29，v1.5.2版本添加 --- 陈风任
     */
    public function admin_logic_balance_pay()
    {
        $syn_admin_logic_balance_pay = tpCache('syn.syn_admin_logic_balance_pay', [], 'cn');
        if (empty($syn_admin_logic_balance_pay)) {
            getUsersConfigData('pay', ['pay_balance_open'=>1]);
            tpCache('syn', ['syn_admin_logic_balance_pay'=>1], 'cn');
        }
    }

    /**
     * 纠正栏目的topid字段值(v1.6.1节点去掉)
     * @return [type] [description]
     */
    public function admin_logic_arctype_topid()
    {
        $syn_admin_logic_arctype_topid = tpCache('syn.syn_admin_logic_arctype_topid', [], 'cn');
        if ($syn_admin_logic_arctype_topid < 2) {
            $level_0_arr = Db::name('arctype')->field('id, topid')->where('grade', 0)->getAllWithIndex('id');
            if (!empty($level_0_arr)) {
                $saveData = [];
                $level_1_arr = Db::name('arctype')->field('id, parent_id')->where(['grade'=>1, 'topid'=>0])->select();
                foreach ($level_1_arr as $key => $val) {
                    $topid = !empty($level_0_arr[$val['parent_id']]) ? intval($level_0_arr[$val['parent_id']]['id']) : 0;
                    $saveData[] = [
                        'id'    => $val['id'],
                        'topid' => $topid,
                        'update_time'   => getTime(),
                    ];
                }
                if (!empty($saveData)) {
                    model('Arctype')->saveAll($saveData);
                }
            }

            $level_1_arr = Db::name('arctype')->field('id, topid')->where('grade', 1)->getAllWithIndex('id');
            if (!empty($level_1_arr)) {
                $saveData = [];
                $level_2_arr = Db::name('arctype')->field('id, parent_id')->where(['grade'=>2, 'topid'=>0])->select();
                foreach ($level_2_arr as $key => $val) {
                    $topid = !empty($level_1_arr[$val['parent_id']]) ? intval($level_1_arr[$val['parent_id']]['topid']) : 0;
                    $saveData[] = [
                        'id'    => $val['id'],
                        'topid' => $topid,
                        'update_time'   => getTime(),
                    ];
                }
                if (!empty($saveData)) {
                    model('Arctype')->saveAll($saveData);
                }
            }
            
            \think\Cache::clear("arctype");
            tpCache('syn', ['syn_admin_logic_arctype_topid'=>2], 'cn');
        }
    }

    /**
     * 文档图片自适应修改为默认关闭(v1.6.1节点去掉)
     */
    public function admin_logic_1610086648()
    {
        $syn_admin_logic_1610086648 = tpCache('syn.syn_admin_logic_1610086648', [], 'cn');
        if (empty($syn_admin_logic_1610086648)) {
            $row = Db::name('config')->where(['name'=>'basic_img_style_wh'])->find();
            if (empty($row)) {
                tpCache('basic', ['basic_img_style_wh'=>0]);
            }
            tpCache('syn', ['syn_admin_logic_1610086648'=>1], 'cn');
        }
    }

    /**
     * 补充站内信模板的数据(v1.6.1节点去掉)
     */
    public function admin_logic_1614829120()
    {
        $syn_admin_logic_1614829120 = tpCache('syn.syn_admin_logic_1614829120', [], 'cn');
        if (empty($syn_admin_logic_1614829120)) {
            try{
                $saveData = [
                    [
                        'tpl_id'    => 1,
                        'tpl_name'    => '留言表单',
                        'tpl_title'    => '您有新的留言消息，请到内容管理中查看！',
                        'tpl_content'    => '${content}',
                        'send_scene'    => 1,
                        'is_open'        => 1,
                        'lang'          => get_main_lang(),
                        'add_time'      => getTime(),
                        'update_time'   => getTime(),
                    ],
                    [
                        'tpl_id'    => 5,
                        'tpl_name'    => '订单付款',
                        'tpl_title'    => '您有新的待发货订单消息，请到商城订单查看！',
                        'tpl_content'    => '${content}',
                        'send_scene'    => 5,
                        'is_open'        => 1,
                        'lang'          => get_main_lang(),
                        'add_time'      => getTime(),
                        'update_time'   => getTime(),
                    ],
                    [
                        'tpl_id'    => 6,
                        'tpl_name'    => '订单发货',
                        'tpl_title'    => '您有新的待收货订单消息，请到会员订单查看！',
                        'tpl_content'    => '${content}',
                        'send_scene'    => 6,
                        'is_open'        => 1,
                        'lang'          => get_main_lang(),
                        'add_time'      => getTime(),
                        'update_time'   => getTime(),
                    ],
                ];
                $r = Db::name('users_notice_tpl')->insertAll($saveData);
                if ($r !== false) {
                    tpCache('syn', ['syn_admin_logic_1614829120'=>1], 'cn');
                }
            }catch(\Exception $e){}
        }

        $syn_admin_logic_1614829121 = tpCache('syn.syn_admin_logic_1614829121', [], 'cn');
        if (empty($syn_admin_logic_1614829121)) {
            try{
                $r = Db::name('users_notice_tpl')->where(['lang'=>['NEQ', get_main_lang()]])->delete();
                if ($r !== false) {
                    tpCache('syn', ['syn_admin_logic_1614829121'=>1], 'cn');
                }
            }catch(\Exception $e){}
        }
    }

    /**
     * 补充邮箱/短信模板的数据(v1.6.1节点去掉)
     */
    public function admin_logic_1616123192()
    {
        $syn_admin_logic_1616123192 = tpCache('syn.syn_admin_logic_1616123192', [], 'cn');
        if (empty($syn_admin_logic_1616123192)) {
            try{
                /*多语言*/
                if (is_language()) {
                    /*邮箱模板 start*/
                    Db::name('smtp_tpl')->where(['send_scene'=>5])->update([
                            'tpl_name'  => '订单付款',
                            'tpl_title' => '您有新的待发货订单消息，请到商城订单查看！',
                            'update_time'   => getTime(),
                        ]);
                    $saveData = [];
                    $langRow = Db::name('language')->field('mark')->order('id asc')->select();
                    foreach ($langRow as $key => $val) {
                        $saveData = [
                            [
                                'tpl_name'  => '订单发货',
                                'tpl_title' => '您有新的待收货订单消息，请到会员订单查看！',
                                'tpl_content'   => '${content}',
                                'send_scene'    => 6,
                                'is_open'   => 1,
                                'lang'          => $val['mark'],
                                'add_time'      => getTime(),
                                'update_time'   => getTime(),
                            ],
                        ];
                        Db::name('smtp_tpl')->insertAll($saveData);
                    }
                    /*邮箱模板 end*/

                    /*短信模板 start*/
                    Db::name('sms_template')->where(['send_scene'=>5])->update([
                            'tpl_title'  => '订单付款',
                            'update_time'   => getTime(),
                        ]);
                    $saveData = Db::name('sms_template')->field('tpl_id', true)->where(['send_scene'=>5])->select();
                    if (!empty($saveData)) {
                        foreach ($saveData as $key => $val) {
                            $val['tpl_title'] = '订单发货';
                            $val['send_scene'] = 6;
                            $saveData[$key] = $val;
                        }
                        Db::name('sms_template')->insertAll($saveData);
                    }
                    /*短信模板 end*/
                }
                else { // 单语言
                    /*邮箱模板 start*/
                    Db::name('smtp_tpl')->where(['send_scene'=>5])->update([
                            'tpl_name'  => '订单付款',
                            'tpl_title' => '您有新的待发货订单消息，请到商城订单查看！',
                            'update_time'   => getTime(),
                        ]);
                    Db::name('smtp_tpl')->insert([
                        'tpl_name'  => '订单发货',
                        'tpl_title' => '您有新的待收货订单消息，请到会员订单查看！',
                        'tpl_content'   => '${content}',
                        'send_scene'    => 6,
                        'is_open'   => 1,
                        'lang'          => get_main_lang(),
                        'add_time'      => getTime(),
                        'update_time'   => getTime(),
                    ]);
                    /*邮箱模板 end*/

                    /*短信模板 start*/
                    Db::name('sms_template')->where(['send_scene'=>5])->update([
                            'tpl_title'  => '订单付款',
                            'update_time'   => getTime(),
                        ]);
                    $saveData = Db::name('sms_template')->field('tpl_id', true)->where(['send_scene'=>5])->select();
                    if (!empty($saveData)) {
                        foreach ($saveData as $key => $val) {
                            $val['tpl_title'] = '订单发货';
                            $val['send_scene'] = 6;
                            $saveData[$key] = $val;
                        }
                        Db::name('sms_template')->insertAll($saveData);
                    }
                    /*短信模板 end*/
                }
                /*--end*/
                tpCache('syn', ['syn_admin_logic_1616123192'=>1], 'cn');
            }catch(\Exception $e){}
        }
    }

    // 补充问题点赞表的like_source字段(v1.6.1节点去掉--陈风任)
    public function admin_logic_1617069276()
    {
        $syn_admin_logic_ask_answer_like = tpCache('syn.syn_admin_logic_ask_answer_like', [], 'cn');
        if (empty($syn_admin_logic_ask_answer_like)) {

            $ask_ques_steps = <<<EOF
1、写问题标题，描述具体现象。杜绝 “求救，大佬，小白…” 等和问题无关的词汇。
2、选择问题的分类，选择正确的内容分类，能更快的得到其他人的回复。
3、遇到的问题比较急需解决，可以给问题悬赏一定的金额报酬，能让更多同行参与进来出谋策划，从中选择自己心仪的答案。
4、写问题内容详细描述你碰到的困难，写清楚你尝试了什么方法，错误代码，软件的版本等，更容易得到答案。
5、点击发布。
EOF;
            tpSetting('ask', ['ask_ques_steps'=>$ask_ques_steps]);

            $getTableInfo = Db::name('ask_answer_like')->getTableFields();
            if (!in_array('like_source', $getTableInfo)) {
                $Prefix = config('database.prefix');
                $likeSql = "ALTER TABLE `{$Prefix}ask_answer_like` ADD COLUMN `like_source` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '点赞来源，1=点赞提问(ask_id)，2=点赞评论(answer_id)，3=点赞回复(answer_id)，默认值为2，兼容以前的那些评论数据' AFTER `click_like`";
                Db::execute($likeSql);
            }
            tpCache('syn', ['syn_admin_logic_ask_answer_like'=>1], 'cn');
        }
    }

    // 纠正商品主表的评价数(appraise字段)、收藏数(collection字段)(v1.6.1节点去掉--陈风任)
    public function admin_logic_archives_1618279798()
    {
        $syn_admin_logic_archives_1618279798 = tpCache('syn.syn_admin_logic_archives_1618279798', [], 'cn');
        if (empty($syn_admin_logic_archives_1618279798)) {
            // 评价数据
            $Field_0 = "product_id as aid, count('comment_id') as appraise, 0 as collection";
            $Data_0 = Db::name('shop_order_comment')->field($Field_0)->group('aid')->select();

            // 收藏数据
            $Field_1 = "aid, count('id') as collection, 0 as appraise";
            $Data_1 = Db::name('users_collection')->field($Field_1)->group('aid')->getAllWithIndex('aid');

            // 整合数据
            $UpdateData = [];
            foreach ($Data_0 as $key => $value) {
                $UpdateData[$key] = $value;
                if ($value['aid'] == $Data_1[$value['aid']]['aid']) {
                    $UpdateData[$key]['collection'] = $Data_1[$value['aid']]['collection'];
                    unset($Data_1[$value['aid']]);
                }
            }

            // 批量处理
            $UpdateData = array_merge($UpdateData, $Data_1);
            if (!empty($UpdateData)) {
                $ArchivesModel = new \app\admin\model\Archives;
                $ArchivesModel->saveAll($UpdateData);
            }

            // 标记已执行
            tpCache('syn', ['syn_admin_logic_archives_1618279798'=>1], 'cn');
        }
    }

    public function admin_logic_1623036205()
    {
        $getTableInfo = [];
        $Prefix = config('database.prefix');

        $syn_admin_logic_1623036205 = tpCache('syn.syn_admin_logic_1623036205', [], 'cn');
        if (empty($syn_admin_logic_1623036205)) {
            $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}sql_cache_table");
            $getTableInfo = get_arr_column($getTableInfo, 'Field');
            if (!empty($getTableInfo) && in_array('sql_result', $getTableInfo)) {
                $SqlCacheTableSql = "ALTER TABLE `{$Prefix}sql_cache_table` MODIFY COLUMN `sql_result` text NOT NULL COMMENT 'mysql执行结果' AFTER `sql_name`";
                Db::execute($SqlCacheTableSql);
            }
            // 标记已执行
            tpCache('syn', ['syn_admin_logic_1623036205'=>1], 'cn');
        }

        // 修复登录logo和背景图的切换
        $admin_logic_1623055490 = tpCache('syn.admin_logic_1623055490', [], 'cn');
        if (empty($admin_logic_1623055490)) {
            $servicemeal = tpCache('php.php_servicemeal');
            if (2 <= $servicemeal) {
                $data = [];
                $web_loginlogo = tpCache('web.web_loginlogo');
                if (stristr($web_loginlogo, 'login-logo_ey.png')) {
                    $data['web_loginlogo'] = ROOT_DIR.'/public/static/admin/images/login-logo_zy.png';
                }
                $web_loginbgimg_model = tpCache('web.web_loginbgimg_model');
                if ($web_loginbgimg_model != 'custom') {
                    $data['web_loginbgimg'] = ROOT_DIR.'/public/static/admin/loginbg/login-bg-3.png';
                }
                !empty($data) && tpCache('web', $data);
            }
            tpCache('syn', ['admin_logic_1623055490'=>1], 'cn');
        }

        $admin_logic_1623133485 = tpCache('syn.admin_logic_1623133485', [], 'cn');
        if (empty($admin_logic_1623133485)) {
            $system_use_language = 0;
            $count = Db::name('language')->count();
            if (1 < $count) {
                $system_use_language = 1;
            }
            tpCache('system', ['system_use_language'=>$system_use_language]);
            tpCache('syn', ['admin_logic_1623133485'=>1], 'cn');
        }

        // 标记用户是否使用旧产品参数
        $syn_admin_logic_1623377269 = tpSetting('syn.syn_admin_logic_1623377269', [], 'cn');
        if (empty($syn_admin_logic_1623377269)) {
            $aids = Db::name('product_attr')->where(['product_attr_id'=>['GT',0]])->column('aid');
            if (empty($aids)) {
                $system_old_product_attr = 0;
            } else {
                $count = Db::name('archives')->where(['aid'=>['IN', $aids]])->count();
                if (empty($count)) { // 这里会误伤正在新增旧产品参数，还没有发布文档的用户
                    $system_old_product_attr = 0;
                    // Db::name('product_attr')->where(['product_attr_id'=>['GT', 0]])->delete();
                    // Db::name('product_attribute')->where(['attr_id'=>['GT', 0]])->delete();
                } else {
                    $system_old_product_attr = 1;
                }
            }
            tpSetting('system', ['system_old_product_attr'=>$system_old_product_attr], 'cn');
            tpSetting('syn', ['syn_admin_logic_1623377269'=>1], 'cn');
        }

        // 新参数属性表加多语言字段
        try {
            $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}shop_product_attribute");
            $getTableInfo = get_arr_column($getTableInfo, 'Field');
            if (!empty($getTableInfo) && !in_array('lang', $getTableInfo)) {
                $SqlCacheTableSql = "ALTER TABLE `{$Prefix}shop_product_attribute` ADD COLUMN `lang`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'cn' COMMENT '语言标识' AFTER `sort_order`";
                $r = Db::execute($SqlCacheTableSql);
                if ($r !== false) {
                    // schemaTable('shop_product_attribute');
                    Db::name('shop_product_attribute')->where(['attr_id'=>['GT',0]])->update(['lang'=>get_main_lang(), 'update_time'=>getTime()]);
                }
            }
        } catch (\Exception $e) {
            
        }

        // 新参数分组表加多语言字段
        try {
            $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}shop_product_attrlist");
            $getTableInfo = get_arr_column($getTableInfo, 'Field');
            if (!empty($getTableInfo) && !in_array('lang', $getTableInfo)) {
                $SqlCacheTableSql = "ALTER TABLE `{$Prefix}shop_product_attrlist` ADD COLUMN `lang`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'cn' COMMENT '语言标识' AFTER `sort_order`;";
                $r = Db::execute($SqlCacheTableSql);
                if ($r !== false) {
                    // schemaTable('shop_product_attrlist');
                    Db::name('shop_product_attrlist')->where(['list_id'=>['GT',0]])->update(['lang'=>get_main_lang(), 'update_time'=>getTime()]);
                }
            }
        } catch (\Exception $e) {
            
        }

        // 付费逻辑处理
        try {
            $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}archives");
            $getTableInfo = get_arr_column($getTableInfo, 'Field');
            if (!empty($getTableInfo) && !in_array('restric_type', $getTableInfo)) {
                $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `restric_type`  tinyint(1) NULL DEFAULT 0 COMMENT '限制模式，0=免费，1=付费，2=会员专享，3=会员付费' AFTER `arc_level_id`;";
                $r = @Db::execute($sql);
                if ($r !== false) {
                    Db::name('channelfield')->where(['name'=>'restric_type','channel_id'=>0])->delete();
                    $sql2 = "INSERT INTO `{$Prefix}channelfield` (`name`, `channel_id`, `title`, `dtype`, `define`, `maxlength`, `dfvalue`, `dfvalue_unit`, `remark`, `is_screening`, `is_release`, `ifeditable`, `ifrequire`, `ifsystem`, `ifmain`, `ifcontrol`, `sort_order`, `status`, `add_time`, `update_time`) VALUES ('restric_type', '0', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251');";
                    @Db::execute($sql2);
                    // schemaTable('archives');
                }
            }
        } catch (\Exception $e) {}

        // 多站点数据表升级
        if (!empty($getTableInfo) && !in_array('province_id', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `province_id`  int(10) NULL DEFAULT 0 COMMENT '省份' AFTER `htmlfilename`;";
            @Db::execute($sql);
            // schemaTable('archives');
        }
        if (!empty($getTableInfo) && !in_array('city_id', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `city_id`  int(10) NULL DEFAULT 0 COMMENT '所在城市' AFTER `province_id`;";
            @Db::execute($sql);
            // schemaTable('archives');
        }
        if (!empty($getTableInfo) && !in_array('area_id', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `area_id`  int(10) NULL DEFAULT 0 COMMENT '所在区域' AFTER `city_id`;";
            @Db::execute($sql);
            // schemaTable('archives');
        }

        $isTable = Db::query('SHOW TABLES LIKE "'.$Prefix.'citysite"');
        if (empty($isTable)) {
            $tableSql = <<<EOF
CREATE TABLE `{$Prefix}citysite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `name` varchar(32) DEFAULT '' COMMENT '地区名称',
  `level` tinyint(4) DEFAULT '0' COMMENT '地区等级 分省市县区',
  `parent_id` int(10) DEFAULT '0' COMMENT '父id',
  `topid` int(10) DEFAULT '0' COMMENT '顶级ID',
  `initial` varchar(5) DEFAULT '' COMMENT '首字母',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（1：开启，0：隐藏）',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否热门',
  `domain` varchar(50) NOT NULL DEFAULT '' COMMENT '二级域名',
  `is_open` tinyint(1) DEFAULT '0' COMMENT '二级域名开启状态，0=否，1=是',
  `seoset` tinyint(1) DEFAULT '0' COMMENT 'SEO设置，0=使用主站，1=自定义',
  `seo_title` varchar(200) DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(200) DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` text COMMENT 'SEO描述',
  `sort_order` int(6) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`) USING BTREE,
  KEY `level` (`level`,`status`) USING BTREE,
  KEY `initial` (`initial`,`sort_order`,`id`) USING BTREE,
  KEY `parent_id` (`parent_id`,`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='城市分站表';
EOF;
            $r = @Db::execute($tableSql);
            if ($r !== false) {
                schemaTable('citysite');
            }
        }

        // 处理视频播放限制模式的数据
        $admin_logic_1624774974 = tpSetting('syn.admin_logic_1624774974', [], 'cn');
        if (empty($admin_logic_1624774974)) {
            $mediaList = Db::name('archives')->where(['channel'=>5])->select();
            if (!empty($mediaList)) {
                $saveData = [];
                foreach ($mediaList as $key => $val) {

                    // 视频限制模型
                    $restric_type = 0;
                    $users_price = floatval($val['users_price']);
                    if (empty($val['arc_level_id']) && empty($users_price)) { // 不限免费
                        $restric_type = 0;
                    } else if (empty($val['arc_level_id']) && 0 < $users_price) { // 不限付费
                        $restric_type = 1;
                    } else if ((!empty($val['arc_level_id']) && empty($users_price)) || !empty($val['users_free'])) { // 会员免费
                        $restric_type = 2;
                    } else if (!empty($val['arc_level_id']) && 0 < $users_price) { // 会员付费
                        $restric_type = 3;
                    }

                    $saveData[] = [
                        'aid'   => $val['aid'],
                        'restric_type' => $restric_type,
                        'update_time'   => getTime(),
                    ];
                }
                if (!empty($saveData)) {
                    $rdata = model('Archives')->saveAll($saveData);
                    if ($rdata !== false) {
                        tpSetting('syn', ['admin_logic_1624774974'=>1], 'cn');
                    }
                }
            }
        }

        // 处理文章付费阅读限制模式的数据
        $admin_logic_1624864940 = tpCache('syn.admin_logic_1624864940', [], 'cn');
        if (empty($admin_logic_1624864940)) {
            $articleList = Db::name('archives')->where(['channel'=>1, 'users_price'=>['gt', 0]])->select();
            if (!empty($articleList)) {
                $saveData = [];
                foreach ($articleList as $key => $val) {

                    // 文章限制模型
                    $restric_type = 0;
                    $users_price = floatval($val['users_price']);
                    if (0 < $users_price) { // 不限付费
                        $restric_type = 1;
                    }

                    $saveData[] = [
                        'aid'   => $val['aid'],
                        'restric_type' => $restric_type,
                        'update_time'   => getTime(),
                    ];
                }
                if (!empty($saveData)) {
                    $rdata = model('Archives')->saveAll($saveData);
                    if ($rdata !== false) {
                        tpCache('syn', ['admin_logic_1624864940'=>1], 'cn');
                    }
                }
            }
        }

        // 纠正支付宝支付配置支付终端数据
        $syn_admin_logic_1625725290 = tpSetting('syn.syn_admin_logic_1625725290', [], 'cn');
        if (empty($syn_admin_logic_1625725290)) {
            $PayInfo = Db::name('pay_api_config')->where(['pay_id'=>'2'])->getField('pay_info');
            $PayInfo = !empty($PayInfo) ? unserialize($PayInfo) : [];
            $PayTerminal = ['computer' => 0, 'c_mark' => 0, 'mobile' => 0, 'm_mark' => 0];
            if (!empty($PayInfo['app_id']) && !empty($PayInfo['merchant_private_key']) && !empty($PayInfo['alipay_public_key'])) {
                $PayTerminal = ['computer' => 1, 'c_mark' => 1, 'mobile' => 0, 'm_mark' => 0];
            }
            $UpAliPay = [
                'update_time' => getTime(),
                'pay_terminal' => serialize($PayTerminal)
            ];
            $ResultID = Db::name('pay_api_config')->where(['pay_id'=>'2'])->update($UpAliPay);
            !empty($ResultID) && tpSetting('syn', ['syn_admin_logic_1625725290'=>1], 'cn');
        }

        // 纠正友情链接分组的多语言问题
        $syn_admin_logic_1629252424 = tpSetting('syn.syn_admin_logic_1629252424', [], 'cn');
        if (empty($syn_admin_logic_1629252424)) {
            // 第一个默认分组
            $firstRow = Db::name('links_group')->where(['id'=>1])->find();
            if (is_language()) {
                Db::name('links_group')->where(['lang'=>['NEQ', $firstRow['lang']]])->delete();
                Db::name('language_attribute')->where(['attr_group'=>'links_group'])->delete();
                Db::name('language_attr')->where(['attr_group'=>'links_group'])->delete();
                $language_attribute_data = $language_attr_data = [];
                $row = Db::name('links_group')->where(['lang'=>$firstRow['lang']])->select();
                foreach ($row as $key => $val) {
                    $language_attribute_data[] = [
                        'attr_title'    => $val['group_name'],
                        'attr_name'    => 'linksgroup'.$val['id'],
                        'attr_group'    => 'links_group',
                        'is_del'    => 0,
                        'add_time'    => getTime(),
                        'update_time'    => getTime(),
                    ];
                    $language_attr_data[] = [
                        'attr_name'    => 'linksgroup'.$val['id'],
                        'attr_value'    => $val['id'],
                        'attr_group'    => 'links_group',
                        'lang'    => $val['lang'],
                        'add_time'    => getTime(),
                        'update_time'    => getTime(),
                    ];
                }

                $row = Db::name('links_group')->where(['lang'=>['EQ', $firstRow['lang']]])->select();
                $langRow = Db::name('language')->field('mark')->where([
                    'mark' => ['NEQ', $firstRow['lang']],
                ])->order('id asc')->select();
                foreach ($row as $_k => $_v) {
                    foreach ($langRow as $key => $val) {
                        $saveData = $_v;
                        unset($saveData['id']);
                        $saveData['group_name'] = $val['mark'].$_v['group_name'];
                        $saveData['lang'] = $val['mark'];
                        $groupid = Db::name('links_group')->insertGetId($saveData);
                        $language_attr_data[] = [
                            'attr_name'    => 'linksgroup'.$_v['id'],
                            'attr_value'    => $groupid,
                            'attr_group'    => 'links_group',
                            'lang'    => $val['mark'],
                            'add_time'    => getTime(),
                            'update_time'    => getTime(),
                        ];
                    }
                }
                !empty($language_attribute_data) && Db::name('language_attribute')->insertAll($language_attribute_data);
                !empty($language_attr_data) && Db::name('language_attr')->insertAll($language_attr_data);
            } else {
                Db::name('links_group')->where(['lang'=>['NEQ', $firstRow['lang']]])->delete();
                Db::name('links')->where(['lang'=>['NEQ', $firstRow['lang']]])->delete();
            }
            tpSetting('syn', ['syn_admin_logic_1629252424'=>1], 'cn');
        }

        if (is_dir('public/static/errpage')) {
            delFile(ROOT_PATH.'public'.DS.'static'.DS.'errpage', true);
        }

        // 栏目文档规则等字段
        $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}arctype");
        $getTableInfo = get_arr_column($getTableInfo, 'Field');
        if (!empty($getTableInfo) && !in_array('diy_dirpath', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}arctype` ADD COLUMN `diy_dirpath`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '列表静态文件存放规则' AFTER `dirpath`;";
            @Db::execute($sql);
            $sql = "DELETE FROM `{$Prefix}channelfield` WHERE `channel_id` = '-99' AND `name` IN ('diy_dirpath');";
            @Db::execute($sql);
            $sql = "INSERT INTO `{$Prefix}channelfield` (`name`, `channel_id`, `title`, `dtype`, `define`, `maxlength`, `dfvalue`, `dfvalue_unit`, `remark`, `is_screening`, `is_release`, `ifeditable`, `ifrequire`, `ifsystem`, `ifmain`, `ifcontrol`, `sort_order`, `status`, `add_time`, `update_time`) VALUES ('diy_dirpath', '-99', '自定义HTML保存路径', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780');";
            @Db::execute($sql);
            $sql = "UPDATE `{$Prefix}arctype` SET `diy_dirpath` = `dirpath`;";
            @Db::execute($sql);
            schemaTable('arctype');
        }
        if (!empty($getTableInfo) && !in_array('rulelist', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}arctype` ADD COLUMN `rulelist`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '列表静态文件存放规则' AFTER `diy_dirpath`;";
            @Db::execute($sql);
            $sql = "DELETE FROM `{$Prefix}channelfield` WHERE `channel_id` = '-99' AND `name` IN ('rulelist');";
            @Db::execute($sql);
            $sql = "INSERT INTO `{$Prefix}channelfield` (`name`, `channel_id`, `title`, `dtype`, `define`, `maxlength`, `dfvalue`, `dfvalue_unit`, `remark`, `is_screening`, `is_release`, `ifeditable`, `ifrequire`, `ifsystem`, `ifmain`, `ifcontrol`, `sort_order`, `status`, `add_time`, `update_time`) VALUES ('rulelist', '-99', '列表静态文件存放规则', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780');";
            @Db::execute($sql);
            schemaTable('arctype');
        }
        if (!empty($getTableInfo) && !in_array('ruleview', $getTableInfo)) {
            $sql = "ALTER TABLE `{$Prefix}arctype` ADD COLUMN `ruleview`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文档静态文件存放规则' AFTER `rulelist`;";
            @Db::execute($sql);
            $sql = "DELETE FROM `{$Prefix}channelfield` WHERE `channel_id` = '-99' AND `name` IN ('ruleview');";
            @Db::execute($sql);
            $sql = "INSERT INTO `{$Prefix}channelfield` (`name`, `channel_id`, `title`, `dtype`, `define`, `maxlength`, `dfvalue`, `dfvalue_unit`, `remark`, `is_screening`, `is_release`, `ifeditable`, `ifrequire`, `ifsystem`, `ifmain`, `ifcontrol`, `sort_order`, `status`, `add_time`, `update_time`) VALUES ('ruleview', '-99', '文档静态文件存放规则', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780');";
            @Db::execute($sql);
            schemaTable('arctype');
        }

        // users表追加union_id
        $getTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}users");
        $getTableInfo = get_arr_column($getTableInfo, 'Field');
        if (!empty($getTableInfo) && !in_array('union_id', $getTableInfo)) {
            try {
                $sql = "ALTER TABLE `{$Prefix}users` ADD COLUMN `union_id`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信用户的unionId' AFTER `coin`;";
                $r = @Db::execute($sql);
                if ($r !== false) {
                    schemaTable('users');
                }
            } catch (\Exception $e) {}
        }

        $isTable = Db::query('SHOW TABLES LIKE "'.$Prefix.'nav_list"');
        if (empty($isTable)) {
            $tableSql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$Prefix}nav_list` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航ID',
  `nav_name` varchar(200) NOT NULL DEFAULT '' COMMENT '导航名称',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `topid` int(10) NOT NULL DEFAULT '0' COMMENT '顶级菜单id',
  `en_name` varchar(200) NOT NULL DEFAULT '' COMMENT '英文名称',
  `nav_url` varchar(200) NOT NULL DEFAULT '' COMMENT '导航链接',
  `position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航位置',
  `arctype_sync` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否与栏目同步',
  `type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同步栏目的ID',
  `nav_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '导航图片',
  `is_remote` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否远程图片',
  `target` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否打开新窗口，1=是，0=否',
  `nofollow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用nofollow，1=是，0=否',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '启用 (1=正常，0=停用)',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序号',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`nav_id`) USING BTREE,
  KEY `position_id` (`position_id`) USING BTREE,
  KEY `type_id` (`type_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='导航列表';
EOF;
            $r = @Db::execute($tableSql);
            if ($r !== false) {
                schemaTable('nav_list');
            }
        }

        $isTable = Db::query('SHOW TABLES LIKE "'.$Prefix.'nav_position"');
        if (empty($isTable)) {
            $tableSql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$Prefix}nav_position` (
  `position_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '导航列表ID',
  `position_name` varchar(200) DEFAULT '' COMMENT '导航列表名称',
  `sort_order` int(10) DEFAULT '0' COMMENT '排序号',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`position_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='导航位置表';
EOF;
            $r = @Db::execute($tableSql);
            if ($r !== false) {
                schemaTable('nav_position');
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('1', 'PC端主导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('2', 'PC端顶部导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('3', 'PC端中部导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('4', 'PC端底部导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('5', '移动端中部导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
                $sql = "INSERT INTO `{$Prefix}nav_position` (`position_id`, `position_name`, `sort_order`, `is_del`, `add_time`, `update_time`) VALUES ('6', '移动端底部导航', '100', '0', '0', '1624861478');";
                @Db::execute($sql);
            }
        }

        // 修复栏目的投稿字段为空时，纠正为0
        $admin_logic_1634204189 = tpSetting('syn.admin_logic_1634204189', [], 'cn');
        if (empty($admin_logic_1634204189)) {
            $sql = "UPDATE `{$Prefix}arctype` SET is_release = 0 WHERE is_release IS NULL;";
            @Db::execute($sql);
            tpSetting('syn', ['admin_logic_1634204189'=>1], 'cn');
        }

        // 纠正栏目的命名规则字段错乱的问题
        $admin_logic_1634280892 = tpSetting('syn.admin_logic_1634280892', [], 'cn');
        if (empty($admin_logic_1634280892)) {
            $arctypeRow = Db::name('arctype')->field('id,rulelist,ruleview')->where(['rulelist'=>['LIKE', '%{aid}%'], 'ruleview'=>['LIKE', '%{tid}%']])->select();
            $saveData = [];
            foreach ($arctypeRow as $key => $val) {
                $saveData[] = [
                    'id'    => $val['id'],
                    'rulelist'    => $val['ruleview'],
                    'ruleview'    => $val['rulelist'],
                    'update_time' => getTime(),
                ];
            }
            if (!empty($saveData)) {
                model('arctype')->saveAll($saveData);
                \think\Cache::clear('arctype');
            }
            tpSetting('syn', ['admin_logic_1634280892'=>1], 'cn');
        }

        // 纠正多语言友情链接的分组标识
        $admin_logic_1635326854 = tpSetting('syn.admin_logic_1635326854', [], 'cn');
        if (empty($admin_logic_1635326854)) {
            $saveData = [];
            $row = Db::name('language_attr')->where(['attr_group'=>'links_group', 'attr_name'=>['LIKE', 'linkgroup%']])->select();
            foreach ($row as $key => $val) {
                $saveData[] = [
                    'id'    => $val['id'],
                    'attr_name' => str_replace('linkgroup', 'linksgroup', $val['attr_name']),
                    'update_time'   => getTime(),
                ];
            }
            if (!empty($saveData)) {
                model('LanguageAttr')->saveAll($saveData);
            }
            tpSetting('syn', ['admin_logic_1635326854'=>1], 'cn');
        }

        // pc/wap跳转js，如果是1.5.5版本开始升级，默认设为关闭，如果是低于或者高于1.5.5升级，默认设为开启
        $admin_logic_1635389623 = tpSetting('syn.admin_logic_1635389623', [], 'cn');
        if (empty($admin_logic_1635389623)) {
            $other_pcwapjs = 0;
            if (file_exists('data/backup/v1.5.5_www')) {
                $seo_pseudo = tpCache('seo.seo_pseudo');
                $count = Db::name('config')->where(['name'=>'other_pcwapjs'])->count('id');
                if (2 == $seo_pseudo && empty($count)) {
                    $other_pcwapjs = 1;
                }
            }
            /*多语言*/
            if (is_language()) {
                $langRow = Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('other', ['other_pcwapjs'=>$other_pcwapjs], $val['mark']);
                }
            } else { // 单语言
                tpCache('other', ['other_pcwapjs'=>$other_pcwapjs]);
            }
            /*--end*/
            tpSetting('syn', ['admin_logic_1635389623'=>1], 'cn');
        }
    }
}
