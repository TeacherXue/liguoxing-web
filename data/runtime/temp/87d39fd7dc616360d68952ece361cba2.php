<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:37:"./template/pc/lists_article_video.htm";i:1778738925;s:45:"/var/www/html/template/pc/includes/header.htm";i:1778738925;s:45:"/var/www/html/template/pc/includes/footer.htm";i:1778738925;}*/ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="block bottomer manufacturer, block bottom machine direct factory, valve bag machinery factory, direct manufacturer of valve bag machines, woven bag production line, PP woven bag machine factory">
  <title>Block Bottomer Manufacturer | LIGUOXING</title>
  <meta name="description" content="Watch factory videos and equipment demonstrations from LIGUOXING, a direct manufacturer of valve bag machines and woven bag production equipment.">
  <link rel="canonical" href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_basehost"); echo $__VALUE__; ?>/video.htm">
  <link rel="stylesheet" href="/css/main.css">
</head>
<body>
  <header class="header">
  <div class="container nav-wrap">
    <a class="logo" href="/" aria-label="LIGUOXING home">
      <img src="/images/logo-liguoxing-header.webp" alt="LIGUOXING logo">
      <div>
        <div class="logo-name">LIGUOXING</div>
        <div class="logo-mark">Industrial Equipment</div>
      </div>
    </a>
    <button class="mobile-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="nav-right">
      <nav class="nav" aria-label="Main Navigation">
        <a href="/" data-i18n-key="nav.home">Home</a>
        <a href="/about.htm" data-i18n-key="nav.about">About Us</a>
        <div class="nav-dropdown">
          <div class="nav-dropdown-head">
            <a class="nav-link" href="/equipment.htm" data-i18n-key="nav.equipment">Equipment</a>
            <button class="nav-dropdown-toggle" type="button" aria-label="Open equipment menu">▾</button>
          </div>
          <div class="nav-submenu" role="menu" aria-label="Equipment models">
            <a href="/equipment.htm" role="menuitem">BVM-120 Model Block Bottom Valve Bag Making Machine</a>
            <a href="/equipment-sfh-800.htm" role="menuitem">SFH-800 Model Twin Extruder Lamination</a>
            <a href="/equipment-gy-800.htm" role="menuitem">GY-800 Serial Printing Machine</a>
          </div>
        </div>
        <a href="/application.htm" data-i18n-key="nav.applications">Applications</a>
        <a href="/video.htm" data-i18n-key="nav.cases">Video</a>
        <a href="/news.htm" data-i18n-key="nav.news">News</a>
        <a href="/contact.htm" data-i18n-key="nav.contact">Contact</a>
        <a href="/download.htm" data-i18n-key="nav.download">Download</a>
      </nav>
      <div class="header-actions">
        <a class="btn btn-primary quote-btn" href="/contact.htm" data-i18n-key="header.quote">Get a Quote</a>
      </div>
    </div>
  </div>
  <button class="mobile-nav-backdrop" type="button" aria-label="Close menu"></button>
</header>


  <section class="page-hero detail-hero">
    <div class="container">
      <h1><?php echo $eyou['field']['typename']; ?></h1>
      <p><?php echo $eyou['field']['seo_description']; ?></p>
    </div>
  </section>

  <main class="content-wrap">
    <div class="container video-library-grid">
      <?php  $typeid = "";  if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  $modelid = "";  if(empty($modelid) && isset($channelartlist["current_channel"]) && !empty($channelartlist["current_channel"])) : $modelid = intval($channelartlist["current_channel"]); endif;  $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "keyword"=> "",      "idlist"=> "",      "idrange"=> "", ); $tagList = new \think\template\taglib\eyou\TagList; $_result_tmp = $tagList->getList($param, 24, "add_time", "", "desc", "on","off","");if(!empty($_result_tmp) && (is_array($_result_tmp) || $_result_tmp instanceof \think\Collection || $_result_tmp instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = $_result = $_result_tmp["list"]; $__PAGES__ = $_result_tmp["pages"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 100, false);$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
      <button class="video-library-card" type="button" data-video-trigger data-video-src="<?php echo $field['jumplinks']; ?>" data-video-title="<?php echo $field['title']; ?>" aria-label="Play <?php echo $field['title']; ?>">
        <span class="video-library-cover">
          <img src="<?php echo $field['litpic']; ?>" alt="<?php echo $field['title']; ?>">
          <span class="video-play-mark" aria-hidden="true"></span>
        </span>
        <span class="video-library-body">
          <span class="video-library-date"><?php echo MyDate('M d, Y',$field['add_time']); ?></span>
          <strong><?php echo $field['title']; ?></strong>
        </span>
      </button>
      <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>
    </div>
  </main>

  <footer class="footer">
  <div class="container footer-top">
    <section class="footer-brand">
      <a class="logo footer-logo" href="/">
        <img src="/images/logo-liguoxing-header.webp" alt="LIGUOXING logo">
        <span><strong>LIGUOXING</strong><small>Industrial Equipment</small></span>
      </a>
      <p data-i18n-key="footer.brand.tagline">Your trusted partner for block bottom valve bag making equipment. High performance. Global service.</p>
      <div class="socials" aria-label="Social links">
        <a href="https://www.instagram.com/leo910508?igsh=NGg0bjN1d3ZudGQ4&amp;utm_source=qr" target="_blank" rel="noopener" aria-label="Instagram">
          <img src="/images/social-instagram.svg" alt="Instagram">
        </a>
        <a href="https://youtube.com/@valvebagequipment?si=iIgk3m1Kx0meyBVe" target="_blank" rel="noopener" aria-label="YouTube">
          <img src="/images/social-youtube.svg" alt="YouTube">
        </a>
        <a href="https://www.facebook.com/share/1CnmhxTrnF/?mibextid=wwXIfr" target="_blank" rel="noopener" aria-label="Facebook">
          <img src="/images/social-facebook.svg" alt="Facebook">
        </a>
        <a href="https://wa.me/8618561683175" target="_blank" rel="noopener" aria-label="WhatsApp">
          <img src="/images/social-whatsapp.svg" alt="WhatsApp">
        </a>
      </div>
    </section>
    <section>
      <h4 data-i18n-key="footer.quickLinks">Quick Links</h4>
      <a href="/about.htm" data-i18n-key="nav.about">About Us</a>
      <a href="/equipment.htm" data-i18n-key="nav.equipment">Equipment</a>
      <a href="/application.htm" data-i18n-key="nav.applications">Applications</a>
      <a href="/video.htm" data-i18n-key="nav.cases">Video</a>
      <a href="/news.htm" data-i18n-key="nav.news">News</a>
      <a href="/contact.htm" data-i18n-key="nav.contact">Contact</a>
    </section>
    <section>
      <h4 data-i18n-key="footer.equipment">Equipment</h4>
      <a href="/equipment.htm" data-i18n-key="footer.equip.bvm120">BVM-120 Model Block Bottom Valve Bag Making Machine</a>
      <a href="/equipment-sfh-800.htm" data-i18n-key="footer.equip.sfh800">SFH-800 Model Twin Extruder Lamination</a>
      <a href="/equipment-gy-800.htm" data-i18n-key="footer.equip.gy800">GY-800 Serial Printing Machine</a>
    </section>
    <section>
      <h4 data-i18n-key="nav.applications">Applications</h4>
      <a href="/applications/cement-valve-bags.htm" data-i18n-key="footer.apps.cement">Cement Valve Bags</a>
      <a href="/applications/open-mouth-bags.htm" data-i18n-key="footer.apps.open">Open-Mouth Bags</a>
      <a href="/applications/powder-mineral-bagging.htm" data-i18n-key="footer.apps.powder">Powder & Mineral Bagging</a>
      <a href="/applications/downstream-automation.htm" data-i18n-key="footer.apps.automation">Downstream Automation</a>
      <a href="/application.htm" data-i18n-key="footer.apps.all">All Applications</a>
    </section>
    <section>
      <h4 data-i18n-key="footer.contact">Contact Us</h4>
      <p>Email: <a href="mailto:leo@liguoxing.com">leo@liguoxing.com</a></p>
      <p>WhatsApp: <a href="https://wa.me/8618561683175" target="_blank" rel="noopener">+86 185 6168 3175</a></p>
      <p data-i18n-key="footer.address">Address: Environment Protection Industrial Park. Longshan. Jimo. Qingdao. China 266201</p>
    </section>
    <section class="qr-wrap">
      <a class="footer-whatsapp-link" href="https://wa.me/8618561683175" target="_blank" rel="noopener" aria-label="Contact us on WhatsApp">
        <img src="/images/footer-whatsapp-qr.webp" alt="WhatsApp QR code">
      </a>
      <p data-i18n-key-html="footer.qr">Message us<br>on WhatsApp</p>
    </section>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <span data-i18n-key="footer.copyright">© 2026 LIGUOXING Machinery Co., Ltd. All rights reserved.</span>
      <span><a href="#" data-i18n-key="footer.privacy">Privacy Policy</a> | <a href="#" data-i18n-key="footer.terms">Terms of Use</a> | <a href="/sitemap.xml" data-i18n-key="footer.sitemap">Sitemap</a></span>
    </div>
  </div>
</footer>

  <script src="/js/site-shell.js?v=20260511-contact"></script>
  <script src="/js/i18n-auto-dict.js"></script>
  <script src="/js/i18n.js"></script>
  <script src="/js/company-video-modal.js"></script>
</body>
</html>
