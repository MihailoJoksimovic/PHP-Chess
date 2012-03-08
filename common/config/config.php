<?php

////////////////////////////////////////////////////////////////////////////////
//
//
// Warm up !
//
////////////////////////////////////////////////////////////////////////////////

session_start();

set_time_limit(0);

date_default_timezone_set("America/New_York");

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . "/../" . PATH_SEPARATOR . dirname(__FILE__) . "/");

require_once dirname(__FILE__) . '/environment.php';

if (!defined("ENVIRONMENT"))
{
    throw new Exception("Environment not defined !");
}

////////////////////////////////////////////////////////////////////////////////
//
//
// Path constants
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Full path to the application directory (including trailing slash !)
 */
define("APP_PATH", dirname(__FILE__) . "/../../");

/**
 * Full path to "var" directory (including trailing slash!)
 */
define("VAR_DIR", APP_PATH . "var/");

/**
 * Full path to "log" directory (including trailing slash!)
 */
define("LOG_DIR", VAR_DIR . "log/");

/**
 * Full path to DIR that contains overridable config files (including trailing slash!)
 */
define("LOCAL_CONFIG_DIR", APP_PATH . "common/config/localhost_config/");

/**
 * Full path to TEMPLATES directory
 */
define("TEMPLATE_DIR", VAR_DIR . "templates/");

////////////////////////////////////////////////////////////////////////////////
//
//
// Environment settings
//
////////////////////////////////////////////////////////////////////////////////


switch (ENVIRONMENT)
{
    case 'live':
	error_reporting(0);
	ini_set('display_errors', 0);
	ini_set('log_errors', 1);
	break;

    default:
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
}

ini_set('error_log', LOG_DIR . "cli/php_errors.log");
ini_set('memory_limit', '256M');

////////////////////////////////////////////////////////////////////////////////
//
//
// DB Config files
//
////////////////////////////////////////////////////////////////////////////////


require_once dirname(__FILE__) . '/db_config.php';


////////////////////////////////////////////////////////////////////////////////
//
//
// Auto-Loader
//
////////////////////////////////////////////////////////////////////////////////

require_once 'config/auto_loader.php';

spl_autoload_register("auto_loader::load");

////////////////////////////////////////////////////////////////////////////////
//
//
// Common Classes
//
////////////////////////////////////////////////////////////////////////////////

require_once APP_PATH . "common/Libs/3rdParty/underscore.php";

require_once APP_PATH . "common/Libs/3rdParty/linklist.class.php";

function d($text)
{
	echo "$text <br/>";
}