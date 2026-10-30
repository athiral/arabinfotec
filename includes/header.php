<?php
// Suppress PHP error display on frontend
@ini_set('display_errors', '0');
@ini_set('display_startup_errors', '0');
@error_reporting(0);

// Clean any pre-existing startup warnings
while (ob_get_level() > 0) {
    @ob_end_clean();
}
ob_start();

/**
 * Common Header for Arabinfotec
 *
 * Accepted variables:
 * - $page_title       : String for <title> and og:title
 * - $page_description : String for <meta name="description"> and og:description
 * - $body_data_page   : String for <body data-page="...">
 * - $body_class       : Optional string for <body class="...">
 * - $base_url         : Optional path prefix, defaults to '' (e.g. '../../' for subdirectories)
 * - $extra_head       : Optional raw HTML inserted in <head>
 */
$base_url = isset($base_url) ? $base_url : '';
$page_title = isset($page_title) ? $page_title : 'Your Digital & IT Partner | Arabinfotec';
$page_description = isset($page_description) ? $page_description : 'Beautiful websites, smarter operations and technology built around your business. Arabinfotec, Dubai.';
$body_data_page = isset($body_data_page) ? $body_data_page : 'home';
$body_class = isset($body_class) ? $body_class : '';
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width,initial-scale=1" name="viewport"/>
  <meta content="<?php echo htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8'); ?>" name="description"/>
  <meta content="#261a38" name="theme-color"/>
  <meta content="<?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>" property="og:title"/>
  <meta content="<?php echo htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8'); ?>" property="og:description"/>
  <meta content="website" property="og:type"/>
  <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
  <link href="<?php echo $base_url; ?>favicon.svg" rel="icon" type="image/svg+xml"/>
  <link rel="preload" href="<?php echo $base_url; ?>assets/font-0.ttf" as="font" type="font/ttf" crossorigin/>
  <link rel="preload" href="<?php echo $base_url; ?>assets/font-1.ttf" as="font" type="font/ttf" crossorigin/>
  <link href="<?php echo $base_url; ?>bundle.min.css?v=1.1" rel="preload" as="style"/>
  <link href="<?php echo $base_url; ?>bundle.min.css?v=1.1" rel="stylesheet"/>
  <?php if (!empty($extra_head)) echo $extra_head; ?>

  <!-- Google Tag Manager (Optimized Loading) -->
  <script>
  window.dataLayer = window.dataLayer || [];
  function initGTM(){
    if(window.gtmDidInit) return;
    window.gtmDidInit = true;
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P6HSXHX9');
  }
  if('requestIdleCallback' in window){
    requestIdleCallback(function(){ setTimeout(initGTM, 1200); }, { timeout: 3000 });
  } else {
    setTimeout(initGTM, 1500);
  }
  ['scroll','mousemove','touchstart'].forEach(function(e){ window.addEventListener(e, initGTM, {once:true, passive:true}); });
  </script>
  <!-- End Google Tag Manager -->
 </head>
 <body data-page="<?php echo htmlspecialchars($body_data_page, ENT_QUOTES, 'UTF-8'); ?>"<?php echo !empty($body_class) ? ' class="' . htmlspecialchars($body_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6HSXHX9"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <a class="skip" href="#main">Skip to content</a>
  <header>
   <a aria-label="Arabinfotec home" href="<?php echo $base_url ? $base_url : './'; ?>">
    <img alt="arabinfotec" class="logo" height="45" src="<?php echo $base_url; ?>assets/logo.png" width="195"/>
   </a>
   <nav aria-label="Main navigation" id="nav">
    <details class="nav-services">
     <summary>
      Services
      <span class="arrow">
       <img src="<?php echo $base_url; ?>assets/down.png" alt="">
      </span>
     </summary>
     <div class="nav-dropdown">
      <a href="<?php echo $base_url; ?>website-design"<?php if ($body_data_page === 'website-design' || $body_data_page === 'services-website') echo ' aria-current="page"'; ?>>Website design</a>
      <a href="<?php echo $base_url; ?>e-commerce"<?php if ($body_data_page === 'e-commerce' || $body_data_page === 'services-ecommerce') echo ' aria-current="page"'; ?>>E-commerce</a>
      <a href="<?php echo $base_url; ?>app-development"<?php if ($body_data_page === 'app-development' || $body_data_page === 'services-software') echo ' aria-current="page"'; ?>>Software &amp; apps</a>
      <a href="<?php echo $base_url; ?>digital-marketing"<?php if ($body_data_page === 'digital-marketing' || $body_data_page === 'services-marketing') echo ' aria-current="page"'; ?>>Digital marketing</a>
     </div>
    </details>

    <details class="nav-services nav-solutions">
     <summary>
      Solutions
      <span class="arrow">
       <img src="<?php echo $base_url; ?>assets/down.png" alt="">
      </span>
     </summary>
     <div class="nav-dropdown">
      <a href="<?php echo $base_url; ?>solutions"<?php if ($body_data_page === 'solutions') echo ' aria-current="page"'; ?>>Explore all solutions &rarr;</a>
      <a href="<?php echo $base_url; ?>solutions/varletpark/">VarletPark<small>Valet Operations</small></a>
      <a href="<?php echo $base_url; ?>solutions/blueforceops/">BlueForceOps<small>Workforce Management</small></a>
      <a href="<?php echo $base_url; ?>solutions/capnav/">CapNav<small>Competency &amp; Certification</small></a>
      <a href="<?php echo $base_url; ?>solutions/parkora/">Parkora<small>Modular Operations</small></a>
      <a href="<?php echo $base_url; ?>solutions/parkora-marine/">Parkora Marine<small>Vessel Operations</small></a>
      <a href="<?php echo $base_url; ?>solutions/crm-software/">CRM Software<small>Sales &amp; Customer Relationships</small></a>
      <a href="<?php echo $base_url; ?>solutions/shortlist-pro/">Shortlist Pro<small>Recruitment Workflows</small></a>
     </div>
    </details>

    <a href="<?php echo $base_url; ?>work" class="me-nav"<?php if ($body_data_page === 'work') echo ' aria-current="page"'; ?>>Our work</a>

    <details class="nav-services">
     <summary>
      About Us
      <span class="arrow">
       <img src="<?php echo $base_url; ?>assets/down.png" alt="">
      </span>
     </summary>
     <div class="nav-dropdown">
      <a href="<?php echo $base_url; ?>about"<?php if ($body_data_page === 'about') echo ' aria-current="page"'; ?>>Our story</a>
      <a href="<?php echo $base_url; ?>team"<?php if ($body_data_page === 'team') echo ' aria-current="page"'; ?>>Our team</a>
     </div>
    </details>
   </nav>
   <a class="nav-cta" href="<?php echo $base_url; ?>contact"<?php if ($body_data_page === 'contact') echo ' aria-current="page"'; ?>>Let&rsquo;s talk <span>&nearrow;</span></a>
   <button aria-controls="nav" aria-expanded="false" aria-label="Open menu" class="menu">☰</button>
  </header>
  <main id="main">
