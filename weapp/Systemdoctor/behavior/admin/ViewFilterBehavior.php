<?php

namespace weapp\Systemdoctor\behavior\admin;

use think\Db;
use weapp\Systemdoctor\logic\SystemdoctorLogic;

/**
 * 系统行为扩展：
 */
class ViewFilterBehavior {
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
        $this->_initialize($params);
    }

    private function _initialize(&$params) {
        $is_security_check = $this->systemdoctorLogic->is_security_check();
        if (1 == $is_security_check) {
            $this->security_verify($params);
        }
    }

    private function security_verify(&$params)
    {
        $sm = input('param.sm/s');
        $sc = input('param.sc/s');
        $sa = input('param.sa/s');
        $weapp_mca = self::$controllerName.'@'.$sm.'/'.$sc.'/'.$sa;
        $weapp_mc_all = self::$controllerName.'@'.$sm.'/'.$sc.'/*';
        $logic = new \weapp\Systemdoctor\logic\SystemdoctorLogic();
        $weapp_second_funclist = $logic->second_funclist();
        if ('GET' == self::$method && 'Systemdoctor' == $sm) {
            $security = tpSetting('security');
            $security_ask = $security['security_ask'];
            $systemdoctor_url = weapp_url('Systemdoctor/Systemdoctor/index');
            $url = url('Security/ajax_answer_verify', ['_ajax'=>1]);
            $replace = <<<EOF
    <script type="text/javascript">
        function autoload_security()
        {
            layer.prompt({
                id: 'layerid_1645598368',
                title: '密保问题<style type="text/css">#layerid_1645598368 {font-size: 13px; font-family: "Microsoft Yahei", "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;}</style>',
                btn: ['确定'],
                shade: [0.7, '#fafafa'],
                closeBtn: 3,
                success: function(layero, index) {
                    var before_str = "<div style='margin: -8px 0px 10px 0px;color: red;font-weight: bold;'>{$security_ask}</div>";
                    $("#layerid_1645598368").prepend(before_str);
                    $("#layerid_1645598368").find('input').attr('placeholder', '请录入密保答案！');
                    $("#layerid_1645598368").find('input').bind('keydown', function(event) {
                        if (event.keyCode == 13) {
                            security_answer_verify($(this).val());
                        }
                    });
                },
                btn2: function(index, layero){
                    window.location.reload();
                    return false;
                },
                cancel: function(index, layero){ 
                    window.location.href = '{$systemdoctor_url}';
                    return false; 
                }
            }, function(value, index) {
                security_answer_verify(value);
            });
        }

        function security_answer_verify(answer)
        {
            $.ajax({
                type : 'post',
                url : "{$url}",
                data : {answer:answer},
                dataType : 'json',
                success : function(res){
                    if (res.code == 1) {
                        layer.closeAll();
                        layer.msg(res.msg, {time: 1000}, function(){
                            window.location.reload();
                        });
                    }else{
                        $('#layerid_1645598368').find('input[type=text]').focus();
                        layer.msg(res.msg, {time: 1000});
                    }
                },
                error: function(e) {
                    showErrorAlert(e.responseText);
                }
            });
        }
    </script>
</body>
EOF;
            $params = str_ireplace('</body>', $replace, $params);

            if (in_array($weapp_mca, $weapp_second_funclist) || in_array($weapp_mc_all, $weapp_second_funclist)) {
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

                $replace = <<<EOF
    <script type="text/javascript">
        autoload_security();
    </script>
</body>
EOF;
                $params = str_ireplace('</body>', $replace, $params);
            }
        }
    }
}
