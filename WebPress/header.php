<?php
session_start();
require_once('./config.php');
require_once('libs/plugin.lib.php');
require_once('libs/users.lib.php');
require_once('libs/utils.lib.php');
require_once('libs/webdb.lib.php');
require_once('libs/files.lib.php');
require_once('libs/Parsedown.lib.php');
require_once('libs/ParsedownExtra.lib.php');
require_once('libs/BBlight.lib.php');
require_once('libs/BBcode.lib.php');
require_once('libs/wysiwyg.lib.php');
require_once('libs/Editor.lib.php');
require_once('libs/CSRF.lib.php');
require_once('libs/Captcha.lib.php');

global $conf, $plugins;
foreach($plugins as $plugin){
	include_once(ROOT.'plugins'.DS.$plugin.DS.$plugin.'.plg.php');
}
CSRF::renewKey();
$parseMD = new ParsedownExtra();
$parseBB = new BBcode();
$Editor = new Editor();

function head($subtitle=null,$basePath='.'){
	if(WebDB::getDB('users', 'views')){
		$views = WebDB::getDB('users', 'views');
		isset($views[date('Y')][date('m')]['views']) ? $views[date('Y')][date('m')]['views'] = intval($views[date('Y')][date('m')]['views']) + 1 : $views[date('Y')][date('m')]['views'] = 1;
		$array = isset($views[date('Y')][date('m')]['unique']) ? $views[date('Y')][date('m')]['unique'] : $views[date('Y')][date('m')]['unique']=array((isset($_SESSION['user']) ? $_SESSION['user'] : '')=>"");
		
			$session = isset($_SESSION['user']) ? $_SESSION['user'] : '';
			if($session===""||in_array($session, $array)){
				# nothing
			}else{
				$session = isset($_SESSION['user']) ? $_SESSION['user'] : '';
				array_push($views[date('Y')][date('m')]['unique'], $session) ? '' : 'failed to add';
			}
		
		$saveviews = json_encode($views);
		file_put_contents(DATA_USERS.'views.dat.json', $saveviews);
	}else{
		$views = array(date('Y')=>array(date('m')=>array('views'=>1, 'unique'=>array($_SESSION['user']))));
		$saveViews = json_encode($views, JSON_PRETTY_PRINT);
		Utils::makeDB('users', 'views', $saveViews);
	}
	$timezone = !gettype(Users::ipInfo(Users::getRealIP(), 'timezone')) ? Users::ipInfo(Users::getRealIP(), 'timezone') : 'America/New_York';
date_default_timezone_set($timezone);
	global $pageTitle, $defaultIcon, $appleIcon, $conf, $pageTheme, $lang;
$header='';
$email = '';
$db = WebDB::getDB('USERS', 'users');
foreach($db as $u => $data){
	if($data['type'] === 'admin'){
		$email = $data['email'];
	}
}
if(version_compare(PHP_VERSION,'7.4', '<')){
	echo '<div style="position:absolute;top:0;left:0;background-color:gray;width:100%;height:100%;z-index:5000;">
	<h1 style="text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-size:72px;color:#00ffff;">You must have PHP 7.4 or later</h1>
	</div>'; 
}else{
$header .= '<html lang="'.Users::getLang().'">
<head>
<meta charset="'.$conf['page']['charset'].'">
<meta name="viewport" content="width=device-width, initial-scale=1">';
$header.='<meta name="description" content="'.$conf['page']['description'][Users::getLang()].'"/>';
$header.='<meta name="author" content="'.$conf['page']['author'].'"/>';
$header .= $conf['page']['refresh']>0 ? '<meta http-equiv="refresh" content="'.$conf['page']['refresh'].'"/>' : '';
$header .= '<meta name="keywords" content="'.$conf['page']['keywords'].'"/>';
$header.= '<meta name="robots" content="'.($conf['page']['robots']['index'] ? 'index' : 'noindex').', '.($conf['page']['robots']['follow'] ? 'follow' : 'nofollow').'"/>';
$header.= $conf['page']['rating']!=="null" ? '<meta name="rating" content="'.$conf['page']['rating'].'"/>' : '';
$header.='<meta name="buildcopyright" content="SurveyBuilderTeams(WebPress)"/>';
$header .= $conf['page']['copyright']!=='' ? '<meta name="copyright" content="'.$conf['page']['copyright'].'"/>' : '';
$header .= '<meta http-equiv="content-language" content="'.strtoupper(Users::getLang()).'">';
$header .= '<meta name="email" content="'.$email.'"/>';
$header .= '<meta name="Distribution" content="'.$conf['page']['distribution'].'">';
$header .= '<meta name="Revisit-after" content="'.$conf['page']['revisted'].'"/>';
$header.= '<noscript><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> '.(isset($lang['index.noScript']) ? $lang['index.noScript'] : '').'</div></noscript>';
$header .='<title>'.(isset($pageTitle) ? $pageTitle : 'Home').(isset($subtitle)||$subtitle!==null ? ' - '.$subtitle : '').' - WebPress</title>';
$header .='<link rel="shortcut icon" type="image/png" href="'.$basePath.DS.(isset($defaultIcon) ? $defaultIcon : '').'"/>';
$header .= '<link rel="apple-touch-icon" type="image/png"  sizes="57x57" href="'.$basePath.DS.(isset($appleIcon) ? $appleIcon : '').'"/>';
$header .= '<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="'.(isset($conf['page']['page-icon']['96']) ? $conf['page']['page-icon']['96'] : '').'"/>';
$header .= '<link rel="apple-touch-icon" type="image/png" sizes="114x144" href="'.(isset($conf['page']['page-icon']['128']) ? $conf['page']['page-icon']['128'] : '').'"/>';
$header .= '<link rel="stylesheet" href="'.$basePath.DS.str_replace('{version}', $conf['fontawesome']['version'], $conf['fontawesome']['cssurl']).'"/>';
$header.= '<link rel="stylesheet" href="'.$basePath.DS.str_replace('{version}', $conf['bootstrap']['version'], $conf['bootstrap']['cssurl']).'"/>';
$header .= '<link rel="stylesheet" href="'.$basePath.DS.str_replace('{version}', $conf['prismJS']['version'], $conf['prismJS']['cssurl']).'"/>';
$header.= '<script src="'.$basePath.DS.str_replace('{version}', $conf['jquery']['version'], $conf['jquery']['jsurl']).'"></script>';
$header.='<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
isset($conf['page']['public'])&&!$conf['page']['public'] ? $header.='<script>window.open('.$BASEPATH.'/, "_blank")</script>' : '';
$header.= ($pageTheme!=="default" ? '<link rel="stylesheet" href="'.$basePath.'/themes/default/css/style.css?v='.uniqid().'"></link>' : '');
$themeSelect = array_diff(scandir('themes/'.$pageTheme.'/css/'), ['.','..']);
foreach($themeSelect as $themes){
	$header.= '<link rel="stylesheet" href="'.$basePath.'/themes/'.$pageTheme.'/css/'.$themes.'?v='.uniqid().'"></link>';
}
$header.= Plugin::hook('head');
$header.='</head>';
return $header;	
}
}
?>
