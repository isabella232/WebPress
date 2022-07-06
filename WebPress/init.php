<?php

# check valid PHP library
if(!extension_loaded('gd')){
	echo 'You must have "gd" enabled';
	return false;
}

date_default_timezone_set("America/New_York");
# defination
$removeSERVER = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']);
$root = str_replace('\\','/',str_replace($removeSERVER,'',__DIR__));



# installations
if(!is_dir('data/users')||!file_exists('data/users/')){
 mkdir('data/users');
}
if(!is_dir('data/plugins')||!file_exists('data/plugins/')){
	 mkdir('data/plugins');
}
if(!is_dir('data/themes')||!file_exists('data/themes/')){
	 mkdir('data/themes');
}
#defined
!defined('DS') ? define('DS', '/') : '';
!defined('ROOT') ? define('ROOT', __DIR__.DS) : '';
$BASEPATH = '.';
!defined('DATA_USERS') ? define('DATA_USERS', ROOT.'data'.DS.'users'.DS) : '';
!defined('DATA_PLUGINS') ? define('DATA_PLUGINS', ROOT.'data'.DS.'plugins'.DS) : '';
!defined('DATA_THEMES') ? define('DATA_THEMES', ROOT.'data'.DS.'themes'.DS) : '';
!defined('DATA_UPLOADS') ? define('DATA_UPLOADS', ROOT.'uploads'.DS) : '';
!defined('DATA_AVATARS') ? define('DATA_AVATARS', '/uploads'.DS.'avatars'.DS) : '';
!defined('DATA_CONFIG') ? define('DATA_CONFIG', $BASEPATH.'/conf'.DS) : '';
!defined('DATA') ? define('DATA', ROOT.'data'.DS) : '';
#Project Info
!defined('PROJECT_NAME') ? define('PROJECT_NAME', 'WebPress') : '';
!defined('PROJECT_BUILD') ? define('PROJECT_BUILD', '220626 <span class="text-secondary" style="font-size:12px;">'.date('d (F) Y', strtotime('22-06-26')).'</span>') : '';
!defined('PROJECT_VERSION') ? define('PROJECT_VERSION', file_get_contents(ROOT.'VERSION')) : '';

#global variable
$plugins = array_diff(scandir(ROOT.'plugins'.DS), ['.','..']);

function langpack(){
	global $lang;
	return array('en-US'=>$lang['lang']['en-US']);
}

?>