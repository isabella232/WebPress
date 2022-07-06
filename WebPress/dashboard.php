<?php 
require_once('init.php');
require_once('config.php');
require_once('header.php');
require_once('footer.php');

global $lang, $selLang, $conf, $defaultIcon;
require_once('lang/'.$selLang.'.php');
?>
<html>
<head>
<?php

$BASEPATH=!preg_match('/\/dashboard(?:\.php\/)/',$_SERVER['REQUEST_URI']) ? '.' : '..';
if(!preg_match('/\/dashboard(?:\.php\/)/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/profile/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.profile'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/configs/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.config'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/docs/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.docs'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/themes/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.themes'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/plugins/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.plugins'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/console/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.console'], $BASEPATH);	
}
if(preg_match('/\/dashboard(?:\.php)\/editors/', $_SERVER['REQUEST_URI'])){
	echo head($lang['dashboard.title.editors'], $BASEPATH);	
}

if(file_exists(DATA_USERS.'users.dat.json')){
	
}else{
		echo '<script>
				window.open("./auth.php/register", "_self");
				</script>';
			return false;
}
if(isset($_SESSION['user'])){
	
}else{
	echo '<script>
				window.open("'.$BASEPATH.'/auth.php/login", "_self");
				</script>';
			return false;
}
?>
</head>
<body>
<?php
$d = WebDB::DBexists('users', 'users') ? WebDB::getDB('users', 'users') : '';
$out='';
if($d[$_SESSION['user']]['type'] === 'admin'){
	$out .= '<div style="background-color: '.$conf['page']['panel']['bgcolor'].'; color:'.$conf['page']['panel']['color'].'">';
	$out.='<nav class="navbar navbar-dark bg-primary navbar-expand-lg" id="dbnavbar">
  <div class="container-fluid">
  <button style="background:transparent;outline:none;border:0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#webpress-sidebar" aria-controls="webpress-sidebar">
  <i class="fas fa-bars" style="color:white;"></i>
</button>
    <a class="navbar-brand">'.$lang['dashboard'].'</a>

	   <button type="button" style="background-color:transparent;border:0;" data-bs-toggle="collapse" data-bs-target="#panel-notify" aria-expanded="false" aria-controls="panelNotify"><i class="fas fa-bell"></i></button>
		<div id="panel-notify" style="position:absolute;left:80%;top:100%;z-index:1000;" class="collapse  text-bg-secondary">
			'.Utils::getUpdates().'
		</div>
	
  </div>
  <span>
  <form method="post" class="m-0">
  <button type="submit" name="webpresslogout" class="btn btn-danger">'.$lang['dashboard.logout'].'</button>
  </form>
  </span>
</nav>';
	$out.='
<div style="background:#b5b5b5;" class="offcanvas offcanvas-start"  tabindex="-1" id="webpress-sidebar" aria-labelledby="staticBackdropLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="staticBackdropLabel">'.$lang['dashboard.side'].'</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>';
	$out .= '<div class="fs-5 p-3 db-welcome">';
	$hrs = date('G');
	$t = preg_replace("/\r|\n/", "", $hrs);
	if((int)$hrs>=0&&(int)$hrs<=11){
		$out .= $lang['dashboard.side.welcome.morn'];
	}elseif((int)$hrs >= 12 && (int)$hrs <= 16){
		$out .= $lang['dashboard.side.welcome.after'];
	}elseif((int)$hrs >= 17 && (int)$hrs <= 20){
		$out .= $lang['dashboard.side.welcome.even'];
	}elseif((int)$hrs >= 21 && (int)$hrs <= 23){
		$out .= $lang['dashboard.side.welcome.night'];
	}
	$getWeather = file_get_contents('https://content.api.nytimes.com/svc/weather/v2/current.json');
	$weather = json_decode($getWeather, true);
	$out .= '<br/>'.$lang['dashboard.side.weather'].' <img src="'.$weather['results'][0]['image'].'" alt="'.$weather['results'][0]['phrase'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$weather['results'][0]['phrase'].'"/>';
	$out .= '<br/>'.(Utils::checkVersion()[0] ? '<div class="alert alert-success" role="alert"><i class="fas fa-check"></i> Current '.Utils::checkVersion()[1].'</div>' : '<div class="alert alert-danger" role="alert"><i class="fas fa-upload"></i> Outdated '.Utils::checkVersion()[1].'</div>');
	$out.='</div>';
      $out.= '  <ul class="list-group list-group-flush">
        <a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/">'.$lang['dashboard.side.home'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard">'.$lang['dashboard.side.back'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/profile">'.$lang['dashboard.side.profile'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/configs">'.$lang['dashboard.side.config'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/docs">'.$lang['dashboard.side.docs'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/themes">'.$lang['dashboard.side.themes'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/plugins">'.$lang['dashboard.side.plugins'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/console#log-1">'.$lang['dashboard.side.console'].'</a>
		<a class="mb-2 list-group-item list-group-item-action list-group-item-secondary" aria-current="page" href="'.$BASEPATH.'/dashboard.php/editors">'.$lang['dashboard.side.editors'].'</a>
		';
		$out.= Plugin::hook('dashboard_list');
		$out.='
      </ul>
    </div>
  </div>
</div>';
if(!preg_match('/\/dashboard(?:\.php\/)/', $_SERVER['REQUEST_URI'])){
	$d = WebDB::DBexists('users', 'users') ? WebDB::getDB('users', 'users') : '';
$out.='<h1 class="text-center">'.$lang['dashboard'].'</h1>';
$out.='<center><div class="text-light bg-secondary p-2 w-50">'.$lang['dashboard.desc'].'</div></center>';
$out.='<div style="height:80%;overflow:auto;">';
$out.='<canvas id="webpress-users" class="dashboard-status"></canvas>';
$out.='<br/>';
$out.='<canvas id="webpress-views" class="dashboard-status"></canvas>';
$out.='<br/>';
$out .= '<div>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Query</th>
	  <th scope="col">Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>PHP Version</th>
	  <th>(7.4)>='.phpversion().'</th>
    </tr>
	 <tr>
      <th>Project Name</th>
	  <th>'.PROJECT_NAME.'</th>
    </tr>
	 <tr>
      <th>Project Version</th>
	  <th>'.Utils::checkVersion()[1].'</th>
    </tr>
	 <tr>
      <th>Project Build</th>
	  <th>'.PROJECT_BUILD.'</th>
    </tr>
	<tr>
      <th>Server Software</th>
	  <th>'.(!empty($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '').'</th>
    </tr>
	<tr>
      <th>PHP Modules</th>
	  <th>'.implode(', ', get_loaded_extensions()).'</th>
    </tr>
	<tr>
      <th>Memory</th>
	  <th>'.Files::sizeFormat(memory_get_usage()).' ('.Files::sizeFormat(memory_get_usage()).') out of '.Files::sizeFormat(memory_get_peak_usage(true)).'</th>
    </tr>
	<tr>
      <th><em>DATA</em> storage</th>
	  <th>'.Files::sizeFormat(Files::folderSize(DATA)).'</th>
    </tr>
	
  </tbody>
</table>
</div>';
$out.='</div>';


}elseif(preg_match('/\/dashboard(?:\.php)\/profile/', $_SERVER['REQUEST_URI'])){
	$out.='<div class="card text-center h-100 w-50 position-realative m-3 start-50 translate-middle-x">
  <div class="card-header">
    '.$lang['dashboard.profile.title'].'
  </div>
  <div class="card-body">
    <h5 class="card-title">'.(isset($_SESSION['user'])?$_SESSION['user']:'').'</h5>
	<div class="container">
	<div class="row">
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.timezone'].$d[$_SESSION['user']]['timezone'].'</p>
	</div>
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.ip'].$d[$_SESSION['user']]['ip'].'</p>
	</div>
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.location'].Users::ipInfo($d[$_SESSION['user']]['ip'], 'location', 'Private IP').'</p>
	</div>
	</div>
	<div class="row">
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.created'].$d[$_SESSION['user']]['created'].'</p>
	</div>
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.email'].$d[$_SESSION['user']]['email'].'</p>
	</div>
	<div class="col">
	<p class="card-text">'.$lang['dashboard.profile.name'].$d[$_SESSION['user']]['name'].'</p>
	</div>
	</div>
	<div class="row">
	<div class="col">
	<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="'.$lang['btn.download'].'" href="'.(file_exists(DATA_UPLOADS.'avatars'.DS.$_SESSION['user'].'.png') ? $BASEPATH.DATA_AVATARS.$_SESSION['user'].'.png' : $BASEPATH.DATA_AVATARS.'default.png').'" download="WebPress-'.$_SESSION['user'].'-avatar">
	<img class="img-fluid rounded avatar" style="width:125px!important;height:125px!important;" src="'.(file_exists(DATA_UPLOADS.'avatars'.DS.$_SESSION['user'].'.png') ? $BASEPATH.DATA_AVATARS.$_SESSION['user'].'.png' : $BASEPATH.DATA_AVATARS.'default.png').'"/>
	</a>
	</div>
	</div>
	<div class="row">
	<div class="col">
	<p class="card-text overflow-auto h-100">'.$lang['dashboard.profile.about'].$d[$_SESSION['user']]['about'].'</p>
	</div>
	<div class="col">
		<label class="form-label" for="user-api"><b>'.$lang['dashboard.userKey'].'</b></label>
	<div class="input-group">
	  <input type="text" id="user-api" class="form-control" readonly="" value="'.(base64_encode(md5($_SESSION['user']))).'"/>
	<button onclick="copyPublicKey()" class="btn btn-secondary input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$lang['dashboard.userKey.copy'].'"><i class="fas fa-copy"></i></button>
	</div>
	</div>
	<div class="col">
		<label class="form-label" for="user-private-api"><b>'.$lang['dashboard.userPKey'].'</b></label>
	<div class="input-group">
	  <input type="text" id="user-private-api" class="form-control" readonly="" value="'.(!file_exists(ROOT.'api'.DS.'KEYS') ? CSRF::generate() : hash('gost', hash('sha512',CSRF::hide()))).'"/>
	<button onclick="copyPrivateKey()" class="btn btn-secondary input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$lang['dashboard.userPKey.copy'].'"><i class="fas fa-copy"></i></button>
	</div>
	</div>
	</div>
	
	</div>
    
    
  </div>
  <div class="card-footer text-muted" style="overflow:auto;">
   <button type="button" data-bs-toggle="modal"  data-bs-target="#apedit" class="btn btn-primary">'.$lang['dashboard.profile.editbtn'].'</button>
  '.(file_exists(DATA_UPLOADS.'avatars'.DS.$_SESSION['user'].'.png') ? '<form method="post" class="m-0 p-0"><button type="submit" name="removedAvatar" class="btn btn-danger">'.$lang['modal.profile.removeAvatar'].'</button></form>' : '').'
  </div>
</div>';
$out.= Users::editProfile();
Utils::isPost('profileEdit', function(){
	global $lang, $BASEPATH;
		$d = WebDB::DBexists('users', 'users') ? WebDB::getDB('users', 'users') : '';
	$username = $_POST['webuser'];
	$name = $_POST['webname'];
	$psw = $_POST['webpsw'];
	$newpsw = $_POST['webnpsw'];
	$about = $_POST['webabout'];
	# change username
	if($username!==""||$username===$_SESSION['user']&&!isset($d[$username])){
		  Files::upload('profileicon', DATA_UPLOADS.'avatars'.DS, (isset($_SESSION['user']) ? $_SESSION['user'].'.png' : null));
		Utils::profileSave('users','users', ['username'=>$username, 'about'=>$about, 'name'=>$name, 'password'=>$psw.'+'.$newpsw]);
		echo Utils::redirect('modal.pedit.title', 'modal.pedit.desc', $BASEPATH.'/dashboard.php/profile', 'success');
		return false;
	}else{
		echo '<div class="alert alert-danger" role="alert">'.$lang['modal.profile.err.user'].'</div>';
		return false;
	}
});
Utils::isPost('removedAvatar', function(){
	global $lang, $BASEPATH;
	echo Files::remove((isset($_SESSION['user']) ? $_SESSION['user'].'.png' : null), DATA_UPLOADS.'avatars'.DS) ? Utils::redirect('modal.pedit.title', 'modal.pedit.desc', $BASEPATH.'/dashboard.php/profile', 'success') : '';
});
}elseif(preg_match('/\/dashboard(?:\.php)\/configs/', $_SERVER['REQUEST_URI'])){
	$out .= '<h1 class="text-center">'.$lang['dashboard.config.title'].'</h1>';
	$out .= '<div class="container"><form method="post">';
	$out.='<div class="row">
	<h4>'.$lang['dashboard.config.page.title'].'</h4>
	<div class="col">
	<input type="text" class="form-control" name="pagetitle" value="'.$conf['page']['page-title'].'"/>
	</div>
	</div>';
	$out.='<div class="row">
	<h4>'.$lang['dashboard.config.pageError.title'].'</h4>

	<div class="col">
	<lable for="err400">400('.$lang['dashboard.config.400'].')</label>
	<textarea class="form-control" style="height: 156px;" id="err400" name="err400">'.$conf['page']['errors']['400'].'</textarea>
	</div>
	<div class="col">
	<lable for="err401">401('.$lang['dashboard.config.401'].')</label>
	<textarea class="form-control" style="height: 156px;" id="err401" name="err401">'.$conf['page']['errors']['401'].'</textarea>
	</div>
	<div class="col">
	<lable for="err403">403('.$lang['dashboard.config.403'].')</label>
	<textarea class="form-control" style="height: 156px;" id="err403" name="err403">'.$conf['page']['errors']['403'].'</textarea>
	</div>
	<div class="col">
	<lable for="err404">404('.$lang['dashboard.config.404'].')</label>
	<textarea class="form-control" style="height: 156px;" id="err404" name="err404">'.$conf['page']['errors']['404'].'</textarea>
	</div>
	<div class="col">
	<lable for="err500">500('.$lang['dashboard.config.500'].')</label>
	<textarea class="form-control" style="height: 156px;" id="err500" name="err500">'.$conf['page']['errors']['500'].'</textarea>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
		<h4>'.$lang['dashboard.config.lang.title'].'</h4>
	<select name="conflang" class="form-control">
	';
	foreach(langpack() as $s=>$l){
		$out .= '<option '.($s===$selLang ? 'selected="selected"' : '').' value="'.$s.'">'.$l.'</option>';
	}
	
	$out.='</select>
	</div>
	<div class="col">
	<h4>'.$lang['dashboard.config.debug.title'].'</h4>
	<select name="confdebug" class="form-control">
	<option value="true" '.($conf['debug'] ? 'selected="selected"' : '').'>'.$lang['config.true'].'</option>
	<option value="false" '.(!$conf['debug'] ? 'selected="selected"' : '').'>'.$lang['config.false'].'</option>
	</select>
	</div>
	<div class="col">
	<div class="input-group p-0">
		<h4>'.$lang['dashboard.config.panel.bgcolor'].'</h4>
    <input type="color" value="'.$conf['page']['panel']['bgcolor'].'" class="form-control b-0 p-0 m-0 form-control-lg w-100 form-control-color" name="panelbgcolor"/>
</div>
	</div>
	<div class="col">
		<div class="input-group p-0">
		<h4>'.$lang['dashboard.config.panel.color'].'</h4>
    <input type="color" value="'.$conf['page']['panel']['color'].'" class="form-control b-0 p-0 m-0 form-control-lg w-100 form-control-color" name="panelcolor"/>
</div>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
	<h4>'.$lang['dashboard.config.captch'].'</h4>
		<select name="captchaActive" class="form-control">
	<option value="true" '.($conf['page']['captcha']['active'] ? 'selected="selected"' : '').'>'.$lang['config.true'].'</option>
	<option value="false" '.(!$conf['page']['captcha']['active'] ? 'selected="selected"' : '').'>'.$lang['config.false'].'</option>
	</select>
	</div>
	<div class="col">
	<h4>'.$lang['dashboard.config.panel.logger'].'</h4>
	<input class="form-control" min="-1" name="displayLogger" type="number" value="'.$conf['page']['panel']['console'].'"/>
	</div>
	<div class="col">
	<h4>'.$lang['dashboard.config.panel.catche'].'</h4>
	<select name="clearCatche" class="form-control" name="clearCatche">
	<option value="">--Select--</option>
	<option value="plugins">Plugins</option>
	<option value="themes">Themes</option>
	</select>
	</div>
	
	</div>';
	$out.='<hr class="border border-5 border-primary"/>';
	$out.='<h1 class="text-center">'.$lang['dashboard.config.seo.title'].' </h1>';
	$out.='<h5><a href="'.$BASEPATH.'/sitemap.xml">'.$lang['sitemap.title'].'</a></h5>';
	$out.='<div class="row">
	<div class="col">
	<h4>'.$lang['dashboard.config.description'].'</h4>
	<textarea class="form-control" style="height: 116px;" name="pageDesc">'.$conf['page']['description'][Users::getLang()].'</textarea>
	</div>
	<div class="col">
	<h4>'.$lang['dashboard.config.author'].'</h4>
	<input type="text" class="form-control" name="pageAuthor" value="'.$conf['page']['author'].'"/>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
		<h4>'.$lang['dashboard.config.refresh'].'<span class="text-secondary"> | </span>'.Users::helpPrompt('dashboard.config.refresh.help').'</h4>
		<input type="number" class="form-control" min="0" name="pageRefresh" value="'.$conf['page']['refresh'].'"/>
	</div>
	<div class="col">
		<h4>'.$lang['dashboard.config.keywords'].'<span class="text-secondary"> | </span>'.Users::helpPrompt('dashboard.config.keywords.help').'</h4>
		<input type="text" class="form-control" name="pageKeywords" value="'.$conf['page']['keywords'].'"/>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
	<h4>'.$lang['dashboard.config.robotIndex.title'].'</h4>
	<select name="robotIndex" class="form-control">
	<option value="true" '.($conf['page']['robots']['index'] ? 'selected="selected"' : '').'>'.$lang['config.true'].'</option>
	<option value="false" '.(!$conf['page']['robots']['index'] ? 'selected="selected"' : '').'>'.$lang['config.false'].'</option>
	</select>
	</div>
	<div class="col">
	<h4>'.$lang['dashboard.config.robotFollow.title'].'</h4>
	<select name="robotFollow" class="form-control">
	<option value="true" '.($conf['page']['robots']['follow'] ? 'selected="selected"' : '').'>'.$lang['config.true'].'</option>
	<option value="false" '.(!$conf['page']['robots']['follow'] ? 'selected="selected"' : '').'>'.$lang['config.false'].'</option>
	</select>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
	<h4>'.$lang['dashboard.config.rate.title'].'</h4>
	<select name="pageRating" class="form-control">';
	foreach($lang['dashboard.config.rate'] as $key => $val){
		$out.= '<option '.($key===str_replace(' ','_',$conf['page']['rating']) ? 'selected="selected"' : '').' value="'.$key.'">'.$val.'</option>';
	}
	$out.='</select>
	</div>
	<div class="col">
		<h4>'.$lang['dashboard.config.copyright'].'</h4>
		<input type="text" class="form-control" name="pageCopyright" value="'.$conf['page']['copyright'].'"/>
	</div>
	</div>';
	$out .= '<div class="row">
	<div class="col">
		<h4>'.$lang['dashboard.config.distribution.title'].'</h4>
	<select name="pageDistribution" class="form-control">';
	foreach($lang['dashboard.config.distribution'] as $key => $val){
		$out.= '<option '.($key===str_replace(' ','_',$conf['page']['distribution']) ? 'selected="selected"' : '').' value="'.$key.'">'.$val.'</option>';
	}
	$out.='</select>
	</div>
	<div class="col">
		<h4>'.$lang['dashboard.config.revisted.title'].'</h4>
	<select name="pageRevisted" class="form-control">';
	foreach($lang['dashboard.config.revisted'] as $key => $val){
		$out.= '<option '.($key===str_replace(' ','_',$conf['page']['revisted']) ? 'selected="selected"' : '').' value="'.$key.'">'.$val.'</option>';
	}
	$out.='</select>
	</div>
	</div>';
	$out.='<div class="row">
	<div class="col">
	<h4>'.$lang['dashboard.config.charset.title'].'</h4>
	<select name="pageCharset" class="form-control">';
	foreach($lang['dashboard.config.charset'] as $key => $val){
		$out.= '<option '.($key===$conf['page']['charset'] ? 'selected="selected"' : '').' value="'.$key.'">'.$val.'</option>';
	}
	$out.='</select>
	</div>
	</div>';
	$out.='<br/>
	<div class="row">
	<div class="col">
	<button type="submit" name="configsave" class="btn btn-success w-100">'.$lang['config.save'].'</button>
	</div></div>';
	$out .='</form></div>';
	Utils::isPost('configsave', function(){
		$d = WebDB::DBexists('CONFIG', 'config') ? WebDB::getDB('CONFIG', 'config') : '';
		global $conf, $BASEPATH;
		$title = isset($_POST['pagetitle'])&& $_POST['pagetitle']!=='' ? $_POST['pagetitle'] : $conf['page']['page-title'];
		$language = isset($_POST['conflang']) ? $_POST['conflang'] : 'en-US';
		$e400 = isset($_POST['err400'])&&$_POST['err400']!=='' ? $_POST['err400'] : $conf['page']['errors']['400'];
		$e401 = isset($_POST['err401'])&&$_POST['err401']!=='' ? $_POST['err401'] : $conf['page']['errors']['401'];
		$e403 = isset($_POST['err403'])&&$_POST['err403']!=='' ? $_POST['err403'] : $conf['page']['errors']['403'];
		$e404 = isset($_POST['err404'])&&$_POST['err404']!=='' ? $_POST['err404'] : $conf['page']['errors']['404'];
		$e500 = isset($_POST['err500'])&&$_POST['err500']!=='' ? $_POST['err500'] : $conf['page']['errors']['500'];
		$debug = isset($_POST['conflang']) ? $_POST['confdebug'] : 'false';
		$webDesc = isset($_POST['pageDesc'])&&$_POST['pageDesc']!=='' ? $_POST['pageDesc'] : $conf['page']['description'][Users::getLang()];
		$author = isset($_POST['pageAuthor'])&&$_POST['pageAuthor']!=='' ? $_POST['pageAuthor'] : $conf['page']['author'];
		$refresh = isset($_POST['pageRefresh'])&&$_POST['pageRefresh']!=='' ? intval($_POST['pageRefresh']) : $conf['page']['refresh'];
		$keywords = isset($_POST['pageKeywords'])&&$_POST['pageKeywords']!=='' ? $_POST['pageKeywords'] : $conf['page']['keywords'];
		$botIndex = isset($_POST['robotIndex']) ? $_POST['robotIndex'] : 'false';
		$botFollow = isset($_POST['robotFollow']) ? $_POST['robotFollow'] : 'false';
		$rating = isset($_POST['pageRating'])&&$_POST['pageRating']!=='' ? $_POST['pageRating'] : $conf['page']['rating'];
		$copyright = isset($_POST['pageCopyright'])&&$_POST['pageCopyright']!=='' ? '&copy;'.str_replace('©','',$_POST['pageCopyright']) : '';
		$distribution = isset($_POST['pageDistribution']) ? $_POST['pageDistribution'] : $conf['page']['distribution'];
		$revisted = isset($_POST['pageRevisted']) ? str_replace('_',' ',$_POST['pageRevisted']) : $conf['page']['pageRevisted'];
		$charset = isset($_POST['pageCharset']) ? $_POST['pageCharset'] : $conf['page']['charset'];
		$bg = isset($_POST['panelbgcolor']) ? $_POST['panelbgcolor'] : $conf['page']['panel']['bgcolor'];
		$color = isset($_POST['panelcolor']) ? $_POST['panelcolor'] : $conf['page']['panel']['color'];
		$captcha = isset($_POST['captchaActive']) ? $_POST['captchaActive'] : 'false';
		$displayConsole = isset($_POST['displayLogger'])&&$_POST['displayLogger']!=='' ? (int)$_POST['displayLogger'] : $conf['page']['panel']['console'];
		$catche = isset($_POST['clearCatche'])&&$_POST['clearCatche']!=='' ? $_POST['clearCatche'] : '';
		
		if($catche!==''){
			Utils::catche($catche);
		}else{
			# nothing
		}
		
		$d['page']['errors']['400'] = $e400;
		$d['page']['errors']['401'] = $e401;
		$d['page']['errors']['403'] = $e403;
		$d['page']['errors']['404'] = $e404;
		$d['page']['errors']['500'] = $e500;
		$d['page']['page-title'] = $title;
		$d['lang'] = $language;
		$d['debug'] = filter_var($debug, FILTER_VALIDATE_BOOLEAN);
		$d['page']['description'][Users::getLang()] = $webDesc;
		$d['page']['author'] = $author;
		$d['page']['refresh'] = $refresh;
		$d['page']['keywords'] = $keywords;
		$d['page']['robots']['index'] = filter_var($botIndex, FILTER_VALIDATE_BOOLEAN);
		$d['page']['robots']['follow'] = filter_var($botFollow, FILTER_VALIDATE_BOOLEAN);
		$d['page']['rating'] = str_replace('_',' ',$rating);
		$d['page']['copyright'] = $copyright;
		$d['page']['distribution'] = $distribution;
		$d['page']['revisted'] = $revisted;
		$d['page']['charset'] = $charset;
		$d['page']['panel']['bgcolor'] = strtoupper($bg);
		$d['page']['panel']['color'] = strtoupper($color);
		$d['page']['captcha']['active'] = filter_var($captcha, FILTER_VALIDATE_BOOLEAN);
		$d['page']['panel']['console'] = $displayConsole;
		
		WebDB::saveDB('CONFIG', 'config', $d) ? Utils::redirect('modal.pedit.title', 'config.success', $BASEPATH.'/dashboard.php/configs', 'success') : Utils::redirect('modal.failed.title', 'config.failed', $BASEPATH.'/dashboard.php/config', 'danger');
	});
}elseif(preg_match('/\/dashboard(?:\.php)\/docs/', $_SERVER['REQUEST_URI'])){
	$out.='<div class="position-relative" style="background-color:#c1c1c14a;height:77.3%;overflow:auto;">';
	$getDoc = file_get_contents(ROOT.'docs'.DS.'doc_'.explode('-',$conf['lang'])[0].'.md');
	$bb = $parseBB->toHTML($getDoc);
	$out.=$parseMD->text($bb);
	
	$out.='</div>';
}elseif(preg_match('/\/dashboard(?:\.php)\/themes/', $_SERVER['REQUEST_URI'])){
	Utils::catche('themes');
foreach(Files::Scan(DATA_THEMES) as $themes){
	if(file_exists(DATA_THEMES.$themes.DS.'theme.conf.json')){
		$lgs = '';
		$themeConfig = WebDB::getDB('THEMES', $themes.DS.'theme', '.conf.json');
		if(isset($themeConfig['options']['usedLang'])){
		for($i=0;$i<count($themeConfig['options']['usedLang']);$i++){
			if($i<count($themeConfig['options']['usedLang'])-1){
				$lgs.= $lang['lang'][$themeConfig['options']['usedLang'][$i]].', ';
			}else{
				$lgs.=$lang['lang'][$themeConfig['options']['usedLang'][$i]];
			}
		}
		}
		$out.='<div class="card h-50 text-bg-secondary theme '.($themeConfig['active']!=='' ? 'theme-active' : '').'" style="width:18rem;">
<div class="card-header text-center h3">
'.(isset($themeConfig['name'][Users::getLang()]) ? $themeConfig['name'][Users::getLang()] : '<div class="alert alert-danger">'.$lang['theme.error.missingName'].'</div>').'
</div>
<div class="card-body text-bg-primary overflow-auto">
'.(isset($themeConfig['desc'][Users::getLang()]) ? $themeConfig['desc'][Users::getLang()] : '<div class="alert alert-danger">'.$lang['theme.error.missingDesc'].'</div>').'
'.(isset($themeConfig['options']['usedLang']) ? '<div class="text-bg-dark">'.$lang['theme.allow.lang'].'<span class="fw-bold fst-italic">'.$lgs.'</span></div>' : '<div class="text-bg-dark">'.$lang['theme.allow.lang'].'<span class="fw-bold fst-italic">'.$lang['theme.allow.lang.null'].'</span></div>').'
</div>
<div class="card-footer p-0">

'.($themes==='default'&&!$themeConfig['options']['canDisabled'] ? '<div data-bs-toggle="tooltip" data-bs-placement="top" title="'.$lang['btn.disabled'].'">' : '').'
<button '.($themes==='default'&&!$themeConfig['options']['canDisabled'] ? 'disabled="disabled"   ' : '').' class="theme-btn '.($themeConfig['active']!=='' ? 'btn-success' : 'btn-danger').' w-100 m-0 btn theme-btn-active">'.($themeConfig['active']!=='' ? $lang['theme.active'] : $lang['theme.deactive']).'</button>
'.($themes==='default'&&!$themeConfig['options']['canDisabled'] ? '</div>' : '').'
</div>
</div>';
	}
}
}elseif(preg_match('/\/dashboard(?:\.php)\/plugins/', $_SERVER['REQUEST_URI'])){
Utils::catche('plugins');
foreach(Files::Scan(DATA_PLUGINS) as $plugins){
	if(file_exists(DATA_PLUGINS.$plugins.DS.'plugin.conf.json')){
		$lgs = '';
		$pluginsConfig = WebDB::getDB('PLUGINS', $plugins.DS.'plugin', '.conf.json');
		if(isset($pluginsConfig['options']['usedLang'])){
		for($i=0;$i<count($pluginsConfig['options']['usedLang']);$i++){
			if($i<count($pluginsConfig['options']['usedLang'])-1){
				$lgs.= $lang['lang'][$pluginsConfig['options']['usedLang'][$i]].', ';
			}else{
				$lgs.=$lang['lang'][$pluginsConfig['options']['usedLang'][$i]];
			}
		}
		}
		$out.='<div class="card h-50 text-bg-secondary plugin '.($pluginsConfig['active']!=='' ? 'plugin-active' : '').'" style="width:18rem;">
<div class="card-header text-center h3">
'.(isset($pluginsConfig['name'][Users::getLang()]) ? $pluginsConfig['name'][Users::getLang()] : '<div class="alert alert-danger">'.$lang['plugin.error.missingName'].'</div>').'
</div>
<div class="card-body text-bg-primary overflow-auto">
'.(isset($pluginsConfig['desc'][Users::getLang()]) ? $pluginsConfig['desc'][Users::getLang()] : '<div class="alert alert-danger">'.$lang['plugin.error.missingDesc'].'</div>').'
<img class="img-fluid plugin-icon" src="'.$BASEPATH.'/data/plugins/'.$plugins.DS.'icon.png"/>
'.(isset($pluginsConfig['options']['usedLang']) ? '<div class="text-bg-dark">'.$lang['plugin.allow.lang'].'<span class="fw-bold fst-italic">'.$lgs.'</span></div>' : '<div class="text-bg-dark">'.$lang['plugin.allow.lang'].'<span class="fw-bold fst-italic">'.$lang['plugin.allow.lang.null'].'</span></div>').'
</div>
<div class="card-footer p-0">

'.($plugins==='Core'&&!$pluginsConfig['options']['canDisabled'] ? '<div data-bs-toggle="tooltip" data-bs-placement="top" title="'.$lang['btn.disabled'].'">' : '').'
<button '.($plugins==='Core'&&!$pluginsConfig['options']['canDisabled'] ? 'disabled="disabled"   ' : '').' class="plugin-btn '.($pluginsConfig['active']!=='' ? 'btn-success' : 'btn-danger').' w-100 m-0 btn theme-btn-active">'.($themeConfig['active']!=='' ? $lang['plugin.active'] : $lang['plugin.deactive']).'</button>
'.($plugins==='Core'&&!$pluginsConfig['options']['canDisabled'] ? '</div>' : '').'
</div>
</div>';
	}
}
}elseif(preg_match('/\/dashboard(?:\.php)\/console/', $_SERVER['REQUEST_URI'])){
	$data = '';
	$getLog = preg_split('/\R/', Files::getFileData(ROOT.'debug.log'));
	$id=0;
	foreach($getLog as $log){
		if($log!==''){
			$id++;
			if($id<=$conf['page']['panel']['console']||$conf['page']['panel']['console']===(int)'-1'){
			if(preg_match('/Warning/', $log)){
				
			$data.='<div log="'.$id.'" id="log-'.$id.'" class="alert alert-warning" role="alert"><a href="./console#log-'.$id.'"><i id="logCapture" class="fas fa-exclamation-triangle"></i></a> <span class="msg">'.$log.'</span><div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    '.$lang['btn.drop.actions.title'].'
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item btn" onclick="copyURLConsole('.$id.')">'.$lang['btn.drop.copy.url'].'</a></li>
    <li><a class="dropdown-item btn" onclick="copyMsgConsole('.$id.')">'.$lang['btn.drop.copy.msg'].'</a></li>
  </ul>
</div></div>';
		}else{
			$data.='<div log="'.$id.'" id="log-'.$id.'" class="alert alert-danger" role="alert"><a href="./console#log-'.$id.'"><i id="logCapture"  class="fas fa-times"></i></a> <span class="msg">'.$log.'</span><div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    '.$lang['btn.drop.actions.title'].'
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item btn" onclick="copyURLConsole('.$id.')">'.$lang['btn.drop.copy.url'].'</a></li>
    <li><a class="dropdown-item btn" onclick="copyMsgConsole('.$id.')">'.$lang['btn.drop.copy.msg'].'</a></li>
  </ul>
</div></div>';

			}
			
			}
		}
	}
	$out.= $conf['debug'] ? '' : '<h4 class="text-center text-bg-danger">'.$lang['debug.off'].'</h4>';
	$out.='<div class="console text-bg-dark" style="height:77.3%;overflow:auto;">
	'.$data.'
	</div>';
}elseif(preg_match('/\/dashboard(?:\.php)\/editors/', $_SERVER['REQUEST_URI'])){
	$out .= $Editor->createEditor($conf['editor']);
}
$out.='</div>';
echo $out;
}
?>
<?php
# actions
if(isset($_POST['webpresslogout'])){
	echo Utils::redirect('auth.logout', 'dashboard.redirect.logout.desc', $BASEPATH.'/auth.php/login', 'danger');
	session_unset();
}
?>
<?php 
echo foot($BASEPATH);
if(!preg_match('/\/dashboard(?:\.php\/)/', $_SERVER['REQUEST_URI'])){
	$db = WebDB::getDB('users', 'users');
$mon = Utils::dateTimeData();
foreach($db as $users){
	preg_match('/\d{4}/', explode('+',$users['created'])[0], $year);
	if($year[0]===date('Y')){
		preg_match('/^\d+(?=\-)/',explode('+',$users['created'])[0], $out);
			if(array_key_exists($out[0], Utils::dateTime('months'))){
				$mon[Utils::dateTime('months')[$out[0]]] = intval($mon[Utils::dateTime('months')[$out[0]]]) + 1 .',';
			}
	}	
}
$views = WebDB::getDB('users', 'views');
$vmon = Utils::dateTimeData();
$vumon = Utils::dateTimeData();
foreach($views as $v=>$vwmon){
	if(date($v)===date('Y')){
		foreach($vwmon as $m=>$vws){
			$vmon[Utils::dateTime('months')[$m]] = $vws['views'] . ',';
			$vumon[Utils::dateTime('months')[$m]] = count($vws['unique']) . ',';
		}
	}
}

# dashboard graph
$out='<script>
var xVal = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov", "Dec"];
var yVal = ['.preg_replace('/\,$/','',$mon['jan'].$mon['feb'].$mon['mar'].$mon['apr'].$mon['may'].$mon['june'].$mon['july'].$mon['aug'].$mon['sept'].$mon['oct'].$mon['nov'].$mon['dec']).'];
new Chart("webpress-users", {
  type: "line",
  data: {
    labels: xVal,
    datasets: [{
		label: "'.$lang['dashboard.graph.user.label'].'",
      fill: false,
      lineTension: 0.1,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yVal
    }]
  },
  options: {
     plugins: {
		 title:{
			 display:true,
			 fullSize: true,
			 text: "'.$lang['dashboard.graph.user.label'].'"
		 },
		 subtitle:{
			 display: true,
			 text:"'.$lang['dashboard.graph.user.subtitle'].date('Y', strtotime('+1 years')).'"
		 },
           legend: {
				title:{
				  display: false,
				}
			}
	 },
    scales: {
      y:{
		  stacked: true,
		   title:{
			   display:true,
			  text: "'.$lang['dashboard.graph.user.y'].'"
		  } 
	  },
	  x:{
		  title:{
			   display:true,
			  text: "'.date('Y').'-'.date('Y', strtotime('+1 years')).'"
		  } 
	  }
    }
  }
});
</script>';
$out.='<script>
var xVWal = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov", "Dec"];
var yVWal = ['.preg_replace('/\,$/','',$vmon['jan'].$vmon['feb'].$vmon['mar'].$vmon['apr'].$vmon['may'].$vmon['june'].$vmon['july'].$vmon['aug'].$vmon['sept'].$vmon['oct'].$vmon['nov'].$vmon['dec']).'];
var uniqUser = ['.preg_replace('/\,$/','',$vumon['jan'].$vumon['feb'].$vumon['mar'].$vumon['apr'].$vumon['may'].$vumon['june'].$vumon['july'].$vumon['aug'].$vumon['sept'].$vumon['oct'].$vumon['nov'].$vumon['dec']).']
new Chart("webpress-views", {
  type: "line",
  data: {
    labels: xVWal,
    datasets: [{
			label: "'.$lang['dashboard.graph.views.unique'].'",
      fill: false,
      lineTension: 0.1,
      backgroundColor: "rgba(0,255,0,1.0)",
      borderColor: "rgba(0,255,0,0.1)",
		data:uniqUser
	},{
		label: "'.$lang['dashboard.graph.views.label'].'",
      fill: false,
      lineTension: 0.1,
      backgroundColor: "rgba(255,0,0,1.0)",
      borderColor: "rgba(255,0,0,0.1)",
      data: yVWal
    }]
  },
  options: {
     plugins: {
		 title:{
			 display:true,
			 fullSize: true,
			 text: "'.$lang['dashboard.graph.views.label'].'"
		 },
		 subtitle:{
			 display: true,
			 text:"'.$lang['dashboard.graph.views.subtitle'].date('Y', strtotime('+1 years')).'"
		 },
           legend: {
				title:{
				  display: false,
				}
			}
	 },
    scales: {
      y:{
		  stacked: true,
		   title:{
			   display:true,
			  text: "'.$lang['dashboard.graph.views.y'].'"
		  } 
	  },
	  x:{
		  title:{
			   display:true,
			  text: "'.date('Y').'-'.date('Y', strtotime('+1 years')).'"
		  } 
	  }
    }
  }
});</script>';

echo $out;
}


?>
</body>
</html>