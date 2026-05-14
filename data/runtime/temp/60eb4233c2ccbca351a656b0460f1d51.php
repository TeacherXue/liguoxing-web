<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:31:"./template/pc/view_download.htm";i:1778738925;s:45:"/var/www/html/template/pc/includes/header.htm";i:1778738925;s:45:"/var/www/html/template/pc/includes/footer.htm";i:1778738925;}*/ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="valve bag machinery factory, woven sack machinery supplier, block bottom valve bag machine manufacturer, PP woven fabric lamination machine manufacturer, woven bag printing machine factory, direct manufacturer of valve bag machines">
  <title>Valve Bag Machinery Factory | LIGUOXING</title>
  <meta name="description" content="Download <?php echo $eyou['field']['title']; ?> from LIGUOXING, a direct manufacturer of valve bag machines and woven sack production equipment.">
  <link rel="canonical" href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_basehost"); echo $__VALUE__; ?>/download/<?php echo $eyou['field']['htmlfilename']; ?>.htm">
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
      <h1><?php echo $eyou['field']['title']; ?></h1>
      <p><?php echo $eyou['field']['seo_description']; ?></p>
    </div>
  </section>

  <main class="content-wrap detail-wrap">
    <div class="container detail-layout">
      <article class="detail-article news-detail-article">
        <div class="detail-meta">
          <span><?php echo $eyou['field']['typename']; ?></span>
          <time datetime="<?php echo MyDate('Y-m-d',$eyou['field']['update_time']); ?>"><?php echo MyDate('M d, Y',$eyou['field']['update_time']); ?></time>
        </div>
        <div class="news-richtext">
          <?php echo $eyou['field']['content']; ?>
        </div>
      </article>
      <aside class="detail-aside">
        <div class="detail-side-card dark-side-card">
          <h3>Files</h3>
          <p><?php echo $eyou['field']['typename']; ?></p>
          <p>Download brochures, technical profiles, and process files.</p>
        </div>
        <div class="detail-side-card related-list">
          <h3>Available Files</h3>
          <?php if(is_array($eyou['field']['file_list']) || $eyou['field']['file_list'] instanceof \think\Collection || $eyou['field']['file_list'] instanceof \think\Paginator): $i = 0; $e = 1; $__LIST__ = $eyou['field']['file_list'];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$file): $i= intval($key) + 1;$mod = ($i % 2 ); ?>
          <a href="<?php echo $file['downurl']; ?>"><?php echo $file['server_name']; ?></a>
          <?php echo $file['ey_1563185380']; ?>
          <?php echo isset($file["ey_1563185380"])?$file["ey_1563185380"]:""; ?><?php echo (1 == $e && isset($file["ey_1563185376"]))?$file["ey_1563185376"]:""; ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $file = []; ?>
        </div>
        <div class="detail-side-card related-list">
          <h3>More Downloads</h3>
          <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = "3"; endif; if(isset($ui_modelid) && !empty($ui_modelid)) : $modelid = $ui_modelid; else: $modelid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 5; endif; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'typeid' => '3',
  'row' => '5',
  'orderby' => 'add_time',
  'ordermode' => 'desc',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "add_time", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],0, $row, true) : $_result["list"]->slice(0, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 100, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); if($field['aid'] != $eyou['field']['aid']): ?>
          <a href="/download/<?php echo $field['htmlfilename']; ?>.htm"><?php echo $field['title']; ?></a>
          <?php endif; ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>
        </div>
        <a class="btn btn-primary detail-cta-button" href="/download.htm">Back to Download <b>-></b></a>
      </aside>
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
  <script src="/public/static/common/js/ey_download_file.js?t=v1.7.6"></script>
</body>
</html>
