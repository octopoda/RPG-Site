<?php
	$title = "";
	$name = "";
  $refer = '';

  curPageURL();
  if (isset($pageURL)) {
    $refer = $pageURL;
  } else {
    $refer = 'index.html';
  }


	if (isset($_GET['title']))
		$title = $_GET['title'];
	if (isset($_GET['name']))
		$name = $_GET['name'];

	$display = new SiteDisplay($title, $name);
	$detect = new MobileDetect();
  $shopping = new ShoppingCart();

  $class = '';
  $class .= ($display->reject == true ? 'disabled' : '');
  $class .= ($detect->isMobile() ? ' mobile' : '') ;
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 oldie" lang="en"> <![endif]-->
<html class="<?php echo $class;  ?> no-js "  lang="en"><head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta charset="utf-8">
  <title><?php echo $site->siteName . $display->displayPageTitle(); ?></title>
  <meta name="description" content="<?php echo $display->displayPageDescription(); ?>">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content="<?php echo $display->displayKeywords(); ?>"  />

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes"/>


  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="/css/basic.css"  />
  <link rel="stylesheet" href="/css/responsive.css">

  <!-- Modernizr -->
  <script src="/js/libs/modernizr-2.5.2.min.js"></script>

  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->


</head>

<body class="<?= $class ?>">

  <div class="outer-wrapper">
  <div class="inner-wrapper">
    <section class="modals">
      <!-- Modal Popup -->
      <?php if ($display->reject == true) : ?>
      <!-- Restricted Form -->

      <div id="restricted" class="modal hide fade"  tabindex="-1"  data-backdrop="static">
        <a class="icon-remove-sign modal-remove" id="modalRemove"></a>
        <div class="modal-header">
          <h3 id="myModalLabel">No Access</h3>
        </div>
        <div class="modal-body">
          <p>You do not have access to this page.  Please click the back button or log in as a member to get access.</p>
            <?php include(SITE_FILES.DS. 'login.php'); ?>
        </div>
      </div>

      <?php else : ?>
          <div class="popupLogin">
            <a class="icon-remove-sign"></a>
            <h4>Member Login</h4>
            <?php include(SITE_FILES.DS. 'login.php'); ?>
          </div>
      <?php endif; ?>

      <!-- Shopping Cart -->
      <!-- <a href="#" class="dev-button clear-cart">Clear Cart</a> -->
      <div  class="popupShoppingCart row-fluid">
          <h1>Your Shopping Cart</h1>
          <div class="full-cart">
              <?php echo $shopping->fullCart(); ?>
          </div>

            <div class="data"></div>
      </div>

    </section>



    <div class="hidden-desktop hidden-tablet hidden-navbar visible-phone"><a href="#" class="nav-button pull-left" id="navButton">Nav</a><a href="/index.html" class="pull-right mobile-logo">RPG</a></div>
    <!-- Nav Column -->
    <section class="navCol">
      <header class="main-navigation">
          <nav class="quickNav">
              <ul>
              <?php if ($display->user->loggedIn) : ?>
                <li><a href="/logout.html">Log Out</a></li>
                <?php if ($display->user->access > 4) : ?>
                <li class="black-ink"><a href="/staff" class="icon-dashboard"><span class="hide">Black Ink</span></a></li>
                <?php endif; ?>
              <?php else:  ?>
                <li><a>Login</a></li>
              <?php endif; ?>
                <li class="shopping">
                  <a class="icon-shopping-cart openCart"><span class="hide">Shopping Cart </span></a>
                  <a class="openCart mini-cart"><?= $shopping->miniCart() ?></a>
                </li>
              </ul>
          </nav>
          <hgroup>
            <h1><a href="/" class="sprites-logo"><?php echo $site->siteName; ?></a></h1>
          </hgroup>
          <?php if ($site->configuration['Search'] == 1) { ?>
             <form class="form-search" id="form" method="GET" action="/search.php" class="search">
                <input class="" type="search" placeholder="search" name="h" id="search">
                <button class="search-btn icon-search" id="searchButton"></button>
             </form>
          <?php } ?>



          <nav class="mainNav">
            <?php $display->displayMenu('Main Menu'); ?>
          </nav>
          <div class="divider"></div>

          <div><?php //$display->displayAds(2); ?></div>
        </header>
    </section>

  <section class="bodyCol">
