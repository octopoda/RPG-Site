<?php
    // Modify this for environment
	defined('SERVER') ? null : define('SERVER', "live");
	global $siteURL;

    if (SERVER == "dev") {
		define("HOSTNAME", "localhost");
		define("DB_USER", "root");
		define("DB_PASS", "V8Juice");
		define("DB_NAME", "renal");

		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS. 'Applications' .DS. 'MAMP' .DS. 'htdocs' .DS. 'RPG-Site' .DS);
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT']);
		define('INCLUDES', SITE_FILES.DS.  "includes" .DS);
		define('MODULES', SITE_FILES.DS.  "modules" .DS);
		define('CSS', SITE_FILES.DS. 'css' .DS);
		define('CACHE_PATH', SITE_FILES.DS . 'cache'. DS);
		define('CLASS_PATH', SITE_FILES.DS. 'lib');
		define('SCRIPTS_PATH', SITE_FILES.DS. 'js');
		define('ADMIN_PATH', CLASS_PATH.DS. 'admin');
		define('FILE_PATH', SITE_FILES.DS."files".DS."uploads");
		define('MAIL_PATH', CLASS_PATH.DS. 'mailer');
		define('PLUGIN_PATH', SITE_FILES.DS. 'plugins');
		define('PLUGIN_LIB', PLUGIN_PATH.DS. 'lib');
		define('PLUGIN_AJAX', PLUGIN_PATH.DS. 'ajax');
		define('E-COM', SITE_FILES.DS. 'store');
		define("PP_CONFIG_PATH", PLUGIN_LIB.DS.'config');
		define("PAYPAL", PLUGIN_LIB.DS.'vendor/paypal/sdk-core-php/lib/config');



		//SMTP
		define('EMAIL_HOST', 'mail.2721west.com');
		define('EMAIL_USER', 'testing@2721west.com');
		define('EMAIL_PASS', '1TestMe!');
		define('EMAIL_PORT', '465');

		define("REPORT_USER", 'testing@2721west.com');
		define("REPORT_PASS", '1TestMe!');

		date_default_timezone_set('America/Dallas');


	}else if (SERVER == "live") {
		//Database
       	define("HOSTNAME", "localhost");
		define("DB_USER", "twosevtw_phuzion");
		define("DB_PASS", "!Q2w#E4r%T6y");
		define("DB_NAME", "twosevtw_renal");

		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS. 'Applications' .DS. 'MAMP' .DS. 'htdocs' .DS. 'blackink' .DS);
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT']);
		define('INCLUDES', SITE_FILES.DS.  "includes" .DS);
		define('MODULES', SITE_FILES.DS.  "modules" .DS);
		define('CSS', SITE_FILES.DS. 'css' .DS);
		define('CLASS_PATH', SITE_FILES.DS. 'lib');
		define('ADMIN_PATH', CLASS_PATH.DS. 'admin');
		define('FILE_PATH', SITE_FILES.DS."files".DS."uploads");
		define('MAIL_PATH', CLASS_PATH.DS. 'mailer');
		define('PLUGIN_PATH', SITE_FILES.DS. 'plugins');
		define('PLUGIN_LIB', PLUGIN_PATH.DS. 'lib');
		define('PLUGIN_AJAX', PLUGIN_PATH.DS. 'ajax');

		//SMTP
		define('EMAIL_HOST', 'host300.hostmonster.com');
		define('EMAIL_USER', 'testing@2721west.com');
		define('EMAIL_PASS', '1TestMe!');
		define('EMAIL_PORT', '465');

		define("REPORT_USER", 'testing@2721west.com');
		define("REPORT_PASS", '1TestMe!');

		date_default_timezone_set('America/Denver');
	}
?>
