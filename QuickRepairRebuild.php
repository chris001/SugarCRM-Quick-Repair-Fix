<?php

if(!defined('sugarEntry'))define('sugarEntry', true);

if (version_compare(phpversion(),'5.2.0') < 0) {
	$msg = 'Minimum PHP version required is 5.2.0.  You are using PHP version  '. phpversion();
    die($msg);
}
$session_id = session_id();
if(empty($session_id)){
	@session_start();
}
//$GLOBALS['installing'] = true;
//define('SUGARCRM_IS_INSTALLING', $GLOBALS['installing']);
$GLOBALS['sql_queries'] = 0;
require_once('include/SugarLogger/LoggerManager.php');
require_once('sugar_version.php');
require_once('suitecrm_version.php');
require_once('include/utils.php');
//require_once('install/install_utils.php');
//require_once('install/install_defaults.php');
require_once('include/TimeDate.php');
require_once('include/Localization/Localization.php');
require_once('include/SugarTheme/SugarTheme.php');
require_once('include/utils/LogicHook.php');
require_once('data/SugarBean.php');
require_once('include/entryPoint.php');
//check to see if the script files need to be rebuilt, add needed variables to request array
$_REQUEST['root_directory'] = getcwd();
$_REQUEST['js_rebuild_concat'] = 'rebuild';
//if(isset($_REQUEST['goto']) && $_REQUEST['goto'] != 'SilentInstall') {
    require_once('jssource/minify.php');
//}

$timedate = TimeDate::getInstance();
// cn: set php.ini settings at entry points
setPhpIniSettings();
$locale = new Localization();

if(get_magic_quotes_gpc() == 1) {
   $_REQUEST = array_map("stripslashes_checkstrings", $_REQUEST);
   $_POST = array_map("stripslashes_checkstrings", $_POST);
   $_GET = array_map("stripslashes_checkstrings", $_GET);
}


$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');



require_once('modules/Administration/QuickRepairAndRebuild.php');
$actions = array('clearAll');
$randc = new RepairAndClear();
echo '<br/>Trying to do a quick repair and rebuild<br/>';
$randc->repairAndClearAll($actions, array(translate('LBL_ALL_MODULES')), true,true);
echo '<br/>Completed quick repair and rebuild.<br/>';

phpinfo();



?>
