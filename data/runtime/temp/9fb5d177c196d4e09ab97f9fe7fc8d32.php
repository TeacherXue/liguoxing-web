<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:44:"./application/admin/template/index/index.htm";i:1759198886;s:61:"/var/www/html/application/admin/template/public/theme_css.htm";i:1721637130;s:59:"/var/www/html/application/admin/template/public/menubox.htm";i:1571728724;s:56:"/var/www/html/application/admin/template/public/left.htm";i:1701045568;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" media="screen"/>
<title>后台管理-<?php if(!(empty($is_eyou_authortoken) || (($is_eyou_authortoken instanceof \think\Collection || $is_eyou_authortoken instanceof \think\Paginator ) && $is_eyou_authortoken->isEmpty()))): ?>易优企业建站系统<?php endif; ?><?php echo $version; ?></title>
<script type="text/javascript">
    var eyou_basefile = "<?php echo \think\Request::instance()->baseFile(); ?>";
    var module_name = "<?php echo MODULE_NAME; ?>";
    var SITEURL = window.location.host + eyou_basefile + "/" + module_name;
    var GetUploadify_url = "<?php echo url('Uploadimgnew/upload'); ?>";
    // 插件专用旧版上传图片框
    if ('Weapp@execute' == "<?php echo CONTROLLER_NAME; ?>@<?php echo ACTION_NAME; ?>") {
      GetUploadify_url = "<?php echo url('Uploadify/upload'); ?>";
    }
    var __root_dir__ = "";
    var __lang__ = "<?php echo $admin_lang; ?>";
    var VarSecurityPatch = <?php echo (isset($security_patch) && ($security_patch !== '')?$security_patch:0); ?>;
    var __seo_pseudo__ = <?php echo (isset($global['seo_pseudo']) && ($global['seo_pseudo'] !== '')?$global['seo_pseudo']:1); ?>;
    var __web_xss_filter__ = <?php echo (isset($global['web_xss_filter']) && ($global['web_xss_filter'] !== '')?$global['web_xss_filter']:0); ?>;
    var __is_mobile__ = <?php echo (isset($is_mobile) && ($is_mobile !== '')?$is_mobile:0); ?>;
    var __security_ask_open__ = <?php echo (isset($global['security_ask_open']) && ($global['security_ask_open'] !== '')?$global['security_ask_open']:0); ?>;
</script>

<link href="/public/static/admin/css/main.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<link href="/public/static/admin/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="/public/static/admin/font/css/font-awesome.min.css" rel="stylesheet" />
<link href="/public/static/admin/font/css/iconfont.css?v=<?php echo $version; ?>" rel="stylesheet" />
<link href="/public/static/admin/css/diy_style.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />
<?php if(file_exists(ROOT_PATH.'public/static/admin/css/theme_style.css')): ?>
    <link href="/public/static/admin/css/theme_style.css?v=<?php echo $version; ?>_<?php echo (isset($global['web_theme_style_uptime']) && ($global['web_theme_style_uptime'] !== '')?$global['web_theme_style_uptime']:0); ?>" rel="stylesheet" type="text/css">
<?php elseif(file_exists(APP_PATH.'admin/template/public/theme_css.htm') && function_exists('hex2rgba')): ?>
    <style type="text/css">
    /*官方内置样式表，升级会覆盖变动，请勿修改，否则后果自负*/

    /*左侧收缩图标*/
    #foldSidebar i { font-size: 24px;color:<?php echo $global['web_theme_color']; ?>; }
    /*左侧菜单*/
    .eycms_cont_left{ background:<?php echo $global['web_theme_color']; ?>; }
    .eycms_cont_left dl dd a:hover,.eycms_cont_left dl dd a.on,.eycms_cont_left dl dt.on{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl dd a:active{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl.jslist dd{ background:<?php echo $global['web_theme_color']; ?>; }
    .eycms_cont_left dl.jslist dd a:hover,.eycms_cont_left dl.jslist dd a.on{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl.jslist:hover{ background:<?php echo $global['web_assist_color']; ?>; }
    /*栏目操作*/
    .cate-dropup .cate-dropup-con a:hover{ background-color: <?php echo $global['web_theme_color']; ?>; }
    /*按钮*/
    a.ncap-btn-green { background-color: <?php echo $global['web_theme_color']; ?>; }
    a:hover.ncap-btn-green { background-color: <?php echo $global['web_assist_color']; ?>; }
    .flexigrid .sDiv2 .btn:hover { background-color: <?php echo $global['web_theme_color']; ?>; }
    .flexigrid .mDiv .fbutton div.add{background-color: <?php echo $global['web_theme_color']; ?>; border: none;}
    .flexigrid .mDiv .fbutton div.add:hover{ background-color: <?php echo $global['web_assist_color']; ?>;}
    .flexigrid .mDiv .fbutton div.adds{color:<?php echo $global['web_theme_color']; ?>;border: 1px solid <?php echo $global['web_theme_color']; ?>;}
    .flexigrid .mDiv .fbutton div.adds:hover{ background-color: <?php echo $global['web_theme_color']; ?>;}
    /*选项卡字体*/
    .tab-base a.current,
    .tab-base a:hover.current {color:<?php echo $global['web_theme_color']; ?> !important;}
    .tab-base a.current:after,
    .tab-base a:hover.current:after {background-color: <?php echo $global['web_theme_color']; ?>;}
    .addartbtn input.btn:hover{ border-bottom: 1px solid <?php echo $global['web_theme_color']; ?>; }
    .addartbtn input.btn.selected{ color: <?php echo $global['web_theme_color']; ?>;border-bottom: 1px solid <?php echo $global['web_theme_color']; ?>;}
    /*会员导航*/
    .member-nav-group .member-nav-item .btn.selected{background: <?php echo $global['web_theme_color']; ?>;border: 1px solid <?php echo $global['web_theme_color']; ?>;box-shadow: -1px 0 0 0 <?php echo $global['web_theme_color']; ?>;}
    .member-nav-group .member-nav-item:first-child .btn.selected{border-left: 1px solid <?php echo $global['web_theme_color']; ?> !important;}
        
    /* 商品订单列表标题 */
   .flexigrid .mDiv .ftitle h3 {border-left: 3px solid <?php echo $global['web_theme_color']; ?>;} 
    
    /*分页*/
    .pagination > .active > a, .pagination > .active > a:focus, 
    .pagination > .active > a:hover, 
    .pagination > .active > span, 
    .pagination > .active > span:focus, 
    .pagination > .active > span:hover { border-color: <?php echo $global['web_theme_color']; ?>;color:<?php echo $global['web_theme_color']; ?>; }
    
    .layui-form-onswitch {border-color: <?php echo $global['web_theme_color']; ?> !important;background-color: <?php echo $global['web_theme_color']; ?> !important;}
    .onoff .cb-enable.selected { background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .onoff .cb-disable.selected {background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .pcwap-onoff .cb-enable.selected { background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .pcwap-onoff .cb-disable.selected {background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    input[type="text"]:focus,
    input[type="text"]:hover,
    input[type="text"]:active,
    input[type="password"]:focus,
    input[type="password"]:hover,
    input[type="password"]:active,
    textarea:hover,
    textarea:focus,
    textarea:active { border-color:<?php echo hex2rgba($global['web_theme_color'],0.8); ?>;box-shadow: 0 0 0 1px <?php echo hex2rgba($global['web_theme_color'],0.5); ?> !important;}
    .input-file-show:hover .type-file-button {background-color:<?php echo $global['web_theme_color']; ?> !important; }
    .input-file-show:hover {border-color: <?php echo $global['web_theme_color']; ?> !important;box-shadow: 0 0 5px <?php echo hex2rgba($global['web_theme_color'],0.5); ?> !important;}
    .input-file-show:hover span.show a,
    .input-file-show span.show a:hover { color: <?php echo $global['web_theme_color']; ?> !important;}
    .input-file-show:hover .type-file-button {background-color: <?php echo $global['web_theme_color']; ?> !important; }
    .color_z { color: <?php echo $global['web_theme_color']; ?> !important;}
    a.imgupload{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    /*专题节点按钮*/
    .ncap-form-default .special-add{background-color:<?php echo $global['web_theme_color']; ?>;border-color:<?php echo $global['web_theme_color']; ?>;}
    .ncap-form-default .special-add:hover{background-color:<?php echo $global['web_assist_color']; ?>;border-color:<?php echo $global['web_assist_color']; ?>;}
    
    /*更多功能标题*/
    .on-off_panel .title::before {background-color:<?php echo $global['web_theme_color']; ?>;}
    .on-off_panel .on-off_list-caidan .icon_bg .on{color: <?php echo $global['web_theme_color']; ?>;}
    .on-off_panel .e-jianhao {color: <?php echo $global['web_theme_color']; ?>;}
    
     /*内容菜单*/
    .ztree li a:hover{color:<?php echo $global['web_theme_color']; ?> !important;}
    .ztree li a.curSelectedNode{background-color: <?php echo $global['web_theme_color']; ?> !important; border-color:<?php echo $global['web_theme_color']; ?> !important;}
    .layout-left .on-off-btn {background-color: <?php echo $global['web_theme_color']; ?> !important;}

    /*框架正在加载*/
    .iframe_loading{width:100%;background:url(/public/static/admin/images/loading-0.gif) no-repeat center center;}
    
    .layui-btn-normal {background-color: <?php echo $global['web_theme_color']; ?>;}
    .layui-laydate .layui-this{background-color: <?php echo $global['web_theme_color']; ?> !important;}
    .laydate-day-mark::after {background-color: <?php echo $global['web_theme_color']; ?> !important;}
	
    /*上传框*/
    .upload-body .upload-con .image-header .image-header-l .layui-btn {
        background: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-tab-brief>.layui-tab-title .layui-this {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-tab-brief>.layui-tab-title .layui-this:after {
        border-bottom-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .layui-layer-btn .layui-layer-btn0 {
        border-color: <?php echo $global['web_theme_color']; ?> !important;
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-btn-yes {
        background: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .pagination li.active a {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-nav .item.active {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .group-item.active a {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .group-item.active {
        color: <?php echo $global['web_theme_color']; ?> !important;
        background-color: <?php echo hex2rgba($global['web_theme_color'],0.1); ?>;
    }
    .pagination li.active {
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-btn-normal {
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .image-list li.up-over .image-select-layer i {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .image-list li .layer .close {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-dirimg-con .ztree li a.curSelectedNode {
         background-color: #FFE6B0 !important; 
         border-color: #FFB951 !important; 
    }
    /*.plug-item-content .plug-item-bottm a, .plug-item-content .plug-status .yes {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }*/
    .ncap-form-default dd.opt .layui-btn{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .marketing_panel .title::before{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .marketing_panel .marketing_list ul.marketing-nav li a .button button {
        color: <?php echo $global['web_theme_color']; ?> !important;
        border: 1px solid <?php echo $global['web_theme_color']; ?> !important;
    }
</style>
<?php endif; ?>
<script type="text/javascript" src="/public/static/common/js/jquery.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/common.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.bgColorSelector.js"></script>
<script type="text/javascript" src="/public/static/admin/js/admincp.js?v=<?php echo $version; ?>0"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.validation.min.js"></script>

<!-- <script type="text/javascript" src="/public/plugins/layer/layer.js"></script> -->
<script type="text/javascript" src="/public/plugins/layer-v3.1.0/layer.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/dialog/dialog.js?v=<?php echo $version; ?>" id="dialog_js"></script>
<script src="/public/static/admin/js/upgrade.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/admin/js/global.js?v=<?php echo $version; ?>"></script>
</head>
<body>

  <script type="text/javascript">
  //固定层移动
  $(function(){
      //管理显示与隐藏
      $('img[tptype="admin_avatar"], #admin-manager-btn').click(function () {
          if ($(".manager-menu").css("display") == "none") {
              $(".manager-menu").css('display', 'block'); 
              $("#admin-manager-btn").attr("title","关闭快捷管理"); 
              $("#admin-manager-btn").removeClass().addClass("arrow-close");
          }
          else {
              $(".manager-menu").css('display', 'none');
              $("#admin-manager-btn").attr("title","显示快捷管理");
              $("#admin-manager-btn").removeClass().addClass("arrow");
          }           
      });
  });
  </script> 
<style>
.scroll-wrapper {   
  height: 100%;
  -webkit-overflow-scrolling: touch;   
  overflow-y: auto;   
} 
</style>
<div class="admincp-container unfold">
<div class="eycms_cont_left hidden-xs">
    <dl class="eylogo">
        <?php if(!(empty($is_eyou_authortoken) || (($is_eyou_authortoken instanceof \think\Collection || $is_eyou_authortoken instanceof \think\Paginator ) && $is_eyou_authortoken->isEmpty()))): ?>
        <a href="<?php echo \think\Request::instance()->url(); ?>"><img id="web_adminlogo" src="<?php echo (isset($web_adminlogo) && ($web_adminlogo !== '')?$web_adminlogo:'/public/static/admin/images/logo_ey.png'); ?>?v=<?php echo time(); ?>" alt="点击刷新"></a>
        <?php else: ?>
        <a href="<?php echo \think\Request::instance()->url(); ?>"><img id="web_adminlogo" src="<?php echo (isset($web_adminlogo) && ($web_adminlogo !== '')?$web_adminlogo:'/public/static/admin/images/logo.png'); ?>?v=<?php echo time(); ?>" alt="点击刷新"></a>
        <?php endif; ?>
    </dl>

    <dl>
        <dd class="sub-menu" id="sub-menu">
            <?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <a data-child="0" class="left_menu_<?php echo $vo['menu_id']; ?> <?php echo $vo['controller_name']; ?>_<?php echo $vo['action_name']; ?>_<?php echo $vo['menu_id']; ?>" 
                id="<?php echo $vo['controller_name']; ?>_<?php echo $vo['action_name']; ?>" 
                <?php if($vo['target'] == '_blank'): ?>
                    href="<?php echo url($vo['controller_name'].'/'.$vo['action_name'], handle_weapp_url($vo['param'], 2)); ?>"
                <?php else: if(empty($all_menu_list[$vo['menu_id']]['url']) || (($all_menu_list[$vo['menu_id']]['url'] instanceof \think\Collection || $all_menu_list[$vo['menu_id']]['url'] instanceof \think\Paginator ) && $all_menu_list[$vo['menu_id']]['url']->isEmpty())): ?> data-menu_id="<?php echo $vo['menu_id']; ?>" data-param="<?php echo $vo['controller_name']; ?>|<?php echo left_menu_id($vo['action_name']); ?><?php echo (isset($vo['param']) && ($vo['param'] !== '')?$vo['param']:''); ?>" href="javascript:void(0);"<?php else: ?> href="<?php echo (isset($all_menu_list[$vo['menu_id']]['url']) && ($all_menu_list[$vo['menu_id']]['url'] !== '')?$all_menu_list[$vo['menu_id']]['url']:'javascript:void(0);'); ?>" <?php endif; endif; ?>
                target="<?php echo (isset($vo['target']) && ($vo['target'] !== '')?$vo['target']:'workspace'); ?>" 
                <?php if(in_array($vo['menu_id'],$not_role_menu_id_arr)): ?>style="display:none"<?php endif; ?> >
                <i class="<?php echo (isset($vo['icon']) && ($vo['icon'] !== '')?$vo['icon']:'fa fa-minus'); ?>"></i><?php echo $vo['title']; ?>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </dd>
    </dl>
</div>
  <div class="admincp-container-right">
    <div class="admincp-header">
    <?php if(($php_servicemeal >= 1 || !empty($global['system_use_language'])) && 'cn' != $languages[$admin_lang]['mark']): ?>
    <div class="<?php if(empty($web_language_switch) || !empty($global['web_citysite_open'])): ?>none<?php endif; ?>" id="Language_index_span" style="position: absolute;text-align: center;margin: 0 auto;width: 100%;">
      <span style="color: red;padding: 6px 21px;display: table;margin: 10px auto;">当前编辑的是<?php echo (isset($languages[$admin_lang]['title']) && ($languages[$admin_lang]['title'] !== '')?$languages[$admin_lang]['title']:'简体中文'); ?>站点</span>
    </div>
    <?php endif; ?>
      <div class="wraper">
        <div class="bgSelector"></div>
        <div id="foldSidebar"><i class="fa fa-bars"></i></div>
        <div class="admincp-name" id="foldSidebar2">
        </div>
        <div class="admincp-header-r">
          <div class="manager">
            <dl>
              <dt class="name"><?php echo $admin_info['user_name']; ?></dt>
              <dd class="group"><?php echo $admin_info['role_name']; ?></dd>
            </dl>
            <div class="btn-group pull-left ey-tool">

              <a class="btn btn-default dropdown-toggle" target="_blank" href="<?php echo $home_url; ?>">
                <i class="iconfont e-website"></i>
                <span class="hidden-xs">网站首页</span>
              </a>

              <?php if(is_check_access('System@clear_cache') == '1'): ?>
                <a class="btn btn-default dropdown-toggle" href="javascript:void(0);" onclick="openItem('System|clear_cache');">
                  <i class="iconfont e-shuaxin"></i>
                  <span class="hidden-xs">清除缓存</span>
                </a>
              <?php endif; if(!(empty($is_eyou_authortoken) || (($is_eyou_authortoken instanceof \think\Collection || $is_eyou_authortoken instanceof \think\Paginator ) && $is_eyou_authortoken->isEmpty()))): ?>
              <!-- 商业授权 -->   
              <em class="eyou_tool em_authortoken" data-expanded="close">
                <a class="btn btn-default dropdown-toggle" href="javascript:void(0);" onclick="valide(this);">
                  <i class="iconfont e-shouquan"></i>
                  <span class="hidden-xs">购买授权</span>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="shouquan">
                    <li class="ey-tool-list text-center"><a target="_blank" class="liaojie" href="https://www.eyoucms.com/buy/"  title="购买后可去除所有版权提示">去购买授权</a></li>
                    <li class="ey-tool-list text-center">
                      <input class="btn btn-primary" type="button" onclick="$('.em_authortoken').toggleClass('open');openItem('Index|authortoken|is_force|1');" value="购买后校验" />
                    </li>
                </ul>
               </em>
              <!-- 商业授权 -->
              <?php endif; ?>

              <!-- 多语言 -->
              <?php if($php_servicemeal >= 1 || !empty($global['system_use_language'])): ?>
              <em id="Language_index" class="eyou_tool em_lang" data-expanded="close" <?php if(empty($web_language_switch) || !empty($global['web_citysite_open'])): ?>style="display: none;"<?php endif; ?>>
                <a class="btn btn-default dropdown-toggle" href="javascript:void(0);" onclick="valide(this);">
                  <i class="iconfont e-duoyuyan"></i>
                  <span class="hidden-xs" id="language_title"><?php echo (isset($languages[$admin_lang]['title']) && ($languages[$admin_lang]['title'] !== '')?$languages[$admin_lang]['title']:'简体中文'); ?></span>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="shouquan">
                  <?php if(is_array($languages) || $languages instanceof \think\Collection || $languages instanceof \think\Paginator): $i = 0; $__LIST__ = $languages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li class="ey-tool-list text-center lang"><a class="liaojie" href="?lang=<?php echo $vo['mark']; ?>"><?php echo $vo['title']; ?></a></li>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                    <li class="ey-tool-list text-center" id="addlang">
                      <button class="btn btn-primary" type="button" onclick="$('.em_lang').toggleClass('open');openItem('Language|index');" />语言管理</button>
                    </li>
                </ul>
               </em>
              <?php endif; ?>
              <!-- 多语言 -->   

              <!-- 小程序 start --> 
              <?php if(!(empty($diyminipro_list) || (($diyminipro_list instanceof \think\Collection || $diyminipro_list instanceof \think\Paginator ) && $diyminipro_list->isEmpty()))): ?>
              <em class="eyou_tool em_diyminipro" data-expanded="close">
                <a class="btn btn-default dropdown-toggle" href="javascript:void(0);" onclick="valide(this);">
                  <i class="iconfont e-xiaochengxu"></i>
                  <span class="hidden-xs">小程序</span>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="shouquan">
                    <?php if(is_array($diyminipro_list) || $diyminipro_list instanceof \think\Collection || $diyminipro_list instanceof \think\Paginator): $i = 0; $__LIST__ = $diyminipro_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li class="ey-tool-list text-center"><a class="liaojie d-pic" href="<?php if($vo['code'] == 'Diyminipro'): ?><?php echo url($vo['code'].'/page_edit'); else: ?><?php echo weapp_url($vo['code'].'/'.$vo['code'].'/page_edit'); endif; ?>" target="_blank" onclick="$('.em_diyminipro').toggleClass('open');"><img src="<?php echo $vo['litpic']; ?>" width="36" height="36"><?php echo $vo['name']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
               </em>
              <?php endif; ?>
              <!-- 小程序 end --> 

              <!-- 服务器升级 -->
              <?php if(empty($security_patch) || (($security_patch instanceof \think\Collection || $security_patch instanceof \think\Paginator ) && $security_patch->isEmpty())): if($upgrade == 'true'): ?>
                <div id="upgrade_filelist" style="display:none;"></div> 
                <div id="upgrade_intro" style="display:none;"></div> 
                <div id="upgrade_notice" style="display:none;"></div> 
                <a class="btn btn-default dropdown-toggle" style="display: none;color:#F00;" title="不升级可能有安全隐患" href="javascript:void(0);" id="a_upgrade" data-version="" data-max_version="" data-curent_version="<?php echo (isset($version) && ($version !== '')?$version:'v1.0'); ?>" data-iframe="parent" data-tips_url="<?php echo url('Upgrade/setPopupUpgrade'); ?>" data-upgrade_url="<?php echo url('Upgrade/OneKeyUpgrade'); ?>" data-check_authority="<?php echo url('Upgrade/check_authority'); ?>" data-php_servicemeal="<?php echo (isset($php_servicemeal) && ($php_servicemeal !== '')?$php_servicemeal:0); ?>">
                  <i class="fa fa-info-circle"></i>
                  <span class="hidden-xs">系统更新</span>
                </a>
                <?php endif; endif; ?>
              <!-- 服务器升级 end -->
            </div>
            
            <div class="admin_user_dropup">
              <div class="admin_user_dropup_bt">
                <img id="admin_head_pic" tptype="admin_avatar" src="<?php echo get_head_pic($admin_info['head_pic'],true); ?>" style="cursor: pointer;width: 34px;height: 34px;">
                <i class="fa fa-angle-down" aria-hidden="true"></i>
                <?php if(empty($is_eyou_authortoken) || (($is_eyou_authortoken instanceof \think\Collection || $is_eyou_authortoken instanceof \think\Paginator ) && $is_eyou_authortoken->isEmpty())): ?>
                <span class="info-num UnreadNotify1615518028 <?php if(empty($notice_count) || (($notice_count instanceof \think\Collection || $notice_count instanceof \think\Paginator ) && $notice_count->isEmpty())): ?>none<?php endif; ?>"><?php echo $notice_count; ?></span>
                <?php endif; ?>
              </div>
              <div class="admin_user_dropup_con">
                <ul>
                  <li><a href="javascript:void(0);" onclick="openItem('Admin|admin_edit|id|<?php echo $admin_info['admin_id']; ?>');">个人信息</a></li>
                  <?php if(is_check_access('Index@theme_index') == '1'): ?>
                  <li><a href="javascript:void(0);" onclick="openItem('Index|theme_index');">主题风格</a></li>
                  <?php endif; if(empty($is_eyou_authortoken) || (($is_eyou_authortoken instanceof \think\Collection || $is_eyou_authortoken instanceof \think\Paginator ) && $is_eyou_authortoken->isEmpty())): ?>
                  <li><a href="javascript:void(0);" onclick="openItem('UsersNotice|admin_notice_index');">站长消息</a><span class="info-num UnreadNotify1615518028 <?php if(empty($notice_count) || (($notice_count instanceof \think\Collection || $notice_count instanceof \think\Paginator ) && $notice_count->isEmpty())): ?>none<?php endif; ?>"><?php echo $notice_count; ?></span></li>
                  <?php endif; ?>
                  <li><a href="<?php echo url('Admin/logout'); ?>">安全退出</a></li>
                </ul>
              </div>
            </div>
            <script type="text/javascript">
              $(".admin_user_dropup").mouseover(function(){
                 $(".admin_user_dropup_con").show();
                 $(".admin_user_dropup_bt").children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
              });
              $(".admin_user_dropup").mouseout(function(){
                 $(".admin_user_dropup_con").hide();
                 $(".admin_user_dropup_bt").children('i').removeClass('fa-angle-up').addClass('fa-angle-down');
              });
            </script>
            
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="top-border"></div>
    <div class="scroll-wrapper">
      <iframe src="<?php echo url('Index/welcome'); ?>" id="workspace" name="workspace" class="iframe_loading" style="overflow-y: auto" frameborder="0" width="100%" height="95%" scrolling="yes" onload="window.parent"></iframe>
      <script type="text/javascript">ajax_system_1610425892();</script>
    </div>
  </div>
</div>
<script type="text/javascript">

  $(function() {
      // iframe 框架显示加载图标，提高体验
      $(".iframe_loading").load(function(){
          // setTimeout(function(){
              $('.iframe_loading').removeClass('iframe_loading');
          // }, 500);
      })
      var php_servicemeal = <?php echo (isset($php_servicemeal) && ($php_servicemeal !== '')?$php_servicemeal:'0'); ?>;

      /* 定时查询未读的站内信 --- 暂定为60秒查询一次 */
      var is_author = <?php echo (isset($is_eyou_authortoken) && ($is_eyou_authortoken !== '')?$is_eyou_authortoken:'0'); ?>;
      if (is_author == 0) {
          window.setInterval(UnreadNotify1615518028, 1*60*1000);
      }
      function UnreadNotify1615518028() {
        $.ajax({
            url : "<?php echo url('Notify/count_unread_notify', ['_ajax'=>1]); ?>",
            type: 'get',
            data: {},
            dataType: 'JSON',
            success: function(res) {
                if (1 == res.code) {
                  $('.UnreadNotify1615518028').empty().html(res.data.notice_count);
                }
            }
        });
      }

      // 轮询更新sitemap.html网站地图
      function UpdateSitemap1647228884(){
          $.ajax({
              url: "/index.php?m=api&c=Sitemap&a=ajax_update_sitemap_html&lang="+__lang__,
              type: "POST",
              dataType: "json",
              data: {is_auto:'off', _ajax:1},
              success: function(res) {

              }
          });
      }
      var sitemap_html = <?php echo (isset($global['sitemap_html']) && ($global['sitemap_html'] !== '')?$global['sitemap_html']:0); ?>;
      if (1 == sitemap_html) {
          UpdateSitemap1647228884();
          window.setInterval(UpdateSitemap1647228884, 2*60*1000);
      }

      // 轮询更新ai_content_index.html网站地图
      function UpdateSitemap1758167419(){
          $.ajax({
              url: "/index.php?m=api&c=Sitemap&a=ajax_update_ai_content_index_html&lang="+__lang__,
              type: "POST",
              dataType: "json",
              data: {is_auto:'off', _ajax:1},
              success: function(res) {

              }
          });
      }
      var ai_content_index_html = <?php echo (isset($global['ai_content_index_html']) && ($global['ai_content_index_html'] !== '')?$global['ai_content_index_html']:0); ?>;
      if (1 == ai_content_index_html && 5 <= php_servicemeal) {
          UpdateSitemap1758167419();
          window.setInterval(UpdateSitemap1758167419, 2*60*1000);
      }

      repair_language_data();
      function repair_language_data() {
        setTimeout(function(){
          $.ajax({
              url : "<?php echo url('Ajax/repair_language_data', ['_ajax'=>1]); ?>",
              type: 'get',
              data: {},
              dataType: 'JSON',
              success: function(res) {

              }
          });
        },1500);
      }

      shopOrderPreHandle();
      function shopOrderPreHandle() {
        $.ajax({
          url : "<?php echo url('Shop/shopOrderPreHandle'); ?>",
          type: 'post',
          data: {_ajax: 1},
          dataType: 'JSON'
        });
      }
  });
  /* END */

  function valide(obj)
  {
    var cls = $(obj).parent().attr('class');
    $('.eyou_tool').removeClass('open');
    if(cls.indexOf("open") > 0) {
      $(obj).parent().addClass('open');
    }
    $(obj).parent().toggleClass('open');
  }

  // 清除缓存
  function clear_cache(clearAll)
  {
      if (!clearAll) {
          clearAll = 0;
      }
      layer_loading('正在清除');
      $.ajax({
          url: "<?php echo url('System/clear_cache', ['_ajax'=>1]); ?>",
          type: 'post',
          dataType: 'JSON',
          data: {clearAll: clearAll},
          success: function(res){
              layer.closeAll();
              if (res.code == 1) {
                  layer.msg(res.msg, {time:1000}, function(){
                    top.window.location.reload();
                  });
              } else {
                  showErrorMsg(res.msg);
              }
          },
          error: function(e){
              showErrorMsg(e.responseText);
          }
      });
  }
</script>
</body>
</html>