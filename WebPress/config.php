<?php
require_once('init.php');
#config(run JSON)
$conf = json_decode(file_get_contents('conf/config.dat.json'), true);
$defaultIcon = $conf['page']['page-icon']['16'];
$appleIcon = $conf['page']['page-icon']['64'];
$pageTitle = $conf['page']['page-title'];
$pageError = $conf['page']['errors'];
$pageTheme = $conf['page']['themes'];
$captchaSettings = $conf['page']['captcha']['settings'];
/*language*/
$selLang = $conf['lang'];

function errormsg($errno, $errstr, $errfile, $errline, $errcontext){
	echo '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> '.$errstr.'</div>';
}
function noticemsg($errno, $errstr, $errfile, $errline, $errcontext){
	echo '<div class="alert alert-warning"><i class="fas fa-exclamation-circle"></i> '.$errstr.'</div>';
}
//set error handler
if (isset($conf['debug'])) {
    ini_set('error_log', ROOT . 'debug.log');
    if ($conf['debug'] === true) {
        error_reporting(E_ALL | E_STRICT | E_NOTICE);
        ini_set('display_errors', true);
        ini_set('display_startup_errors', true);
        ini_set("track_errors", 1);
        ini_set('html_errors', 1);
    } elseif ($conf['debug'] === false) {
        error_reporting(0);
        ini_set('display_errors', false);
        ini_set('display_startup_errors', false);
    }
}

?>