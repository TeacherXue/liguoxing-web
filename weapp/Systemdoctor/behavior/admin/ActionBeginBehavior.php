<?php

namespace weapp\Systemdoctor\behavior\admin;

use think\Db;
use weapp\Systemdoctor\logic\SystemdoctorLogic;

/**
 * 系统行为扩展：新增/更新/删除之后的后置操作
 */
load_trait('controller/Jump');
class ActionBeginBehavior {
    use \traits\controller\Jump;
    protected static $actionName;
    protected static $controllerName;
    protected static $moduleName;
    protected static $method;
    public $systemdoctorLogic;

    /**
     * 构造方法
     * @param Request $request Request对象
     * @access public
     */
    public function __construct()
    {
        $this->systemdoctorLogic = new SystemdoctorLogic;
    }

    // 行为扩展的执行入口必须是run
    public function run(&$params){
        self::$actionName = request()->action();
        self::$controllerName = request()->controller();
        self::$moduleName = request()->module();
        self::$method = request()->method();
        $this->_initialize();
    }

    private function _initialize() {
        $is_security_check = $this->systemdoctorLogic->is_security_check();
        if (1 == $is_security_check) {
            $this->security_verify();
        }
    }

    private function security_verify()
    {
        $sm = input('param.sm/s');
        $sc = input('param.sc/s');
        $sa = input('param.sa/s');
        $weapp_mca = self::$controllerName.'@'.$sm.'/'.$sc.'/'.$sa;
        $weapp_mc_all = self::$controllerName.'@'.$sm.'/'.$sc.'/*';
        $logic = new \weapp\Systemdoctor\logic\SystemdoctorLogic();
        $weapp_second_funclist = $logic->second_funclist();
        if (in_array($weapp_mca, $weapp_second_funclist) || in_array($weapp_mc_all, $weapp_second_funclist)) {
            $security = tpSetting('security');

            /*---------强制必须开启密保问题认证 start----------*/
            if (in_array($weapp_mca, $weapp_second_funclist) || in_array($weapp_mc_all, $weapp_second_funclist)) {
                if (empty($security['security_ask_open'])) {
                    $this->error("<span style='display:none;'>__html__</span>需要开启密保问题设置", url('Security/index'), '', 3);
                }
            }
            /*---------强制必须开启密保问题认证 end----------*/

            $nosubmit = input('param.nosubmit/d');
            if ('POST' == self::$method && empty($nosubmit)) {
                if (!empty($security['security_ask_open']) && (in_array($weapp_mca, $weapp_second_funclist) || in_array($weapp_mc_all, $weapp_second_funclist))) {

                } else {
                    return true;
                }
                $admin_id = session('?admin_id') ? (int)session('admin_id') : 0;
                $admin_info = Db::name('admin')->field('admin_id,last_ip')->where(['admin_id'=>$admin_id])->find();
                // 当前管理员二次安全验证过的IP地址
                $security_answerverify_ip = !empty($security['security_answerverify_ip']) ? $security['security_answerverify_ip'] : '-1';
                // 同IP不验证
                if ($admin_info['last_ip'] == $security_answerverify_ip) {
                    return true;
                }

                $this->error("<span style='display:none;'>__html__</span>出于安全考虑<br/>请勿非法越过密保答案验证", null, '', 3);
            }
        }
    }
}
