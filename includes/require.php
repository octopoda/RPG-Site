<?php
	require_once($_SERVER['DOCUMENT_ROOT']. "/lib/web_config.php");
	

	require_once(CLASS_PATH.DS. "database.php");
	require_once(CLASS_PATH.DS. "databaseObject.php");
	require_once(CLASS_PATH.DS. "functions.php");
	require_once(CLASS_PATH.DS. "site.php");

	//Library
	require_once(CLASS_PATH.DS. 'address.php');
	require_once(CLASS_PATH.DS. 'ads.php');
	require_once(CLASS_PATH.DS. "contactinformation.php");
	require_once(CLASS_PATH.DS. 'content.php');
	require_once(CLASS_PATH.DS. 'display.php');
	require_once(CLASS_PATH.DS. 'errors.php');
	require_once(CLASS_PATH.DS. 'installer.php');
	require_once(CLASS_PATH.DS. 'media.php');
	require_once(CLASS_PATH.DS. 'menus.php');
	require_once(CLASS_PATH.DS. 'mobiledetect.php');
	require_once(CLASS_PATH.DS. 'moduledecoder.php');
	require_once(CLASS_PATH.DS. 'navigation.php');
	require_once(CLASS_PATH.DS. 'news.php');
	require_once(CLASS_PATH.DS. 'pagination.php');
	require_once(CLASS_PATH.DS. 'Pest.php');
	require_once(CLASS_PATH.DS. 'phone.php');
	require_once(CLASS_PATH.DS. 'phones.php');
	require_once(CLASS_PATH.DS. 'search.php');
	require_once(CLASS_PATH.DS. 'site.php');
	require_once(CLASS_PATH.DS. 'sitemap.php');
	require_once(CLASS_PATH.DS. 'social.php');
	require_once(CLASS_PATH.DS. 'userGroups.php');
	require_once(CLASS_PATH.DS. 'users.php');


	//Admin
	require_once(ADMIN_PATH.DS. 'adminnavigation.php');
	require_once(ADMIN_PATH.DS. 'grid.php');

	// //Mail
	require_once(MAIL_PATH.DS. 'class.phpmailer.php');
	require_once(MAIL_PATH.DS. 'class.smtp.php');

	//Plugins
	require_once(PLUGIN_LIB.DS. 'archive.php');
	require_once(PLUGIN_LIB.DS. 'article.php');
	require_once(PLUGIN_LIB.DS. 'authorizecheckout.php');
	require_once(PLUGIN_LIB.DS. 'categories.php');
	require_once(PLUGIN_LIB.DS. 'checkout.php');
	require_once(PLUGIN_LIB.DS. 'commerce.php');
	require_once(PLUGIN_LIB.DS. 'frontpage.php');
	require_once(PLUGIN_LIB.DS. 'gcalendar.php');
	require_once(PLUGIN_LIB.DS. 'gevent.php');
	require_once(PLUGIN_LIB.DS. 'orders.php');
	require_once(PLUGIN_LIB.DS. 'payment_setup.php');
	require_once(PLUGIN_LIB.DS. 'paypalcheckout.php');
	require_once(PLUGIN_LIB.DS. 'productcategories.php');
	require_once(PLUGIN_LIB.DS. 'products.php');
	require_once(PLUGIN_LIB.DS. 'purchases.php');
	require_once(PLUGIN_LIB.DS. 'shoppingCart.php');
	require_once(PLUGIN_LIB.DS. 'simple_html_dom.php');
	require_once(PLUGIN_LIB.DS. 'sitedisplay.php');
	require_once(PLUGIN_LIB.DS. 'subcats.php');

	//SDK

	$site = new Site();

?>