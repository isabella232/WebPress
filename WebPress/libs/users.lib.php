<?php
class Users{
	private function __construct(){
		
	}
	public static function getRealIP(){
	if($_SERVER['SERVER_NAME'] === "localhost"){
			$ip = getHostByName(getHostName());
		}elseif(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
public static function ipInfo($ip, $sel, $msg=''){ 
	# ipinfo
	$info = @json_decode(file_get_contents('https://ipinfo.io/'.$ip.'/json'), true) ? true : false;
	$msg = $msg!=='' ? $msg : '';
	$msg = !$info ? 'Failed to connect' : $msg;
	$out = $info ? 'yes' : 'no';
	//$out = !$info['bogon']&&$info!==false ? $info[$sel] : $msg;
	return $out;
}

public static function getSession(){
	return isset($_SESSION['user'])&&WebDB::getDB('users', 'users') ? $_SESSION['user'] : false;
}
public static function isAdmin(){
	return WebDB::getDB('users', 'users')[$_SESSION['user']]['type']==='admin' ? true : false;
}
public static function isMod(){
	return WebDB::getDB('users', 'users')[$_SESSION['user']]['type']==='mod' ? true : false;
}
public static function isMember(){
	return WebDB::getDB('users', 'users')[$_SESSION['user']]['type']==='member' ? true : false;
}
# Custom roles
public static function isRole($role){
	return WebDB::getDB('users', 'users')[$_SESSION['user']]['type']===$role ? true : false;
}
#editProfile
public static function editProfile($base=''){
	global $lang;
	$d = WebDB::getDB('users','users');
	return '<!-- Modal -->
<div class="modal fade" data-bs-backdrop="static" id="apedit" tabindex="-1" aria-labelledby="apeditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="apeditlable">'.$lang['modal.profile'].'</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
		<div class="row">
		<div class="col">
		<label for="webuser" class="form-label">'.$lang['modal.profile.username'].'</label>
		<input type="text" id="webuser" name="webuser" class="form-control" value="'.(isset($_SESSION['user']) ? $_SESSION['user'] : '').'" placeholder="'.$lang['modal.profile.username'].'"/>
		</div>
		<div class="col">
		<label for="webname" class="form-label">'.$lang['modal.profile.name'].'</label>
		<input type="text" id="webname" name="webname" class="form-control" value="'.(isset($d[$_SESSION['user']]['name']) ? $d[$_SESSION['user']]['name'] : '').'" placeholder="'.$lang['modal.profile.username'].'"/>
		</div>
		</div>
		<div class="row">
		<div class="col">
		<label for="webpsw" class="form-label">'.$lang['modal.profile.oldpsw'].'</label>
		<input type="password" id="webpsw" name="webpsw" class="form-control" placeholder="'.$lang['modal.profile.oldpsw'].'"/>
		  <div class="invalid-feedback">
      Please provide your old password.
    </div>
		</div>
		<div class="col">
		<label for="webnpsw" class="form-label">'.$lang['modal.profile.newpsw'].'</label>
		<input type="password" id="webnpsw" name="webnpsw" class="form-control" placeholder="'.$lang['modal.profile.newpsw'].'"/>
		<p class="text-muted">'.$lang['modal.profile.newpsw.note'].'</p>
		</div>
		</div>
		<div class="row">
		<div class="col">
		<label for="webabout" class="form-label">'.$lang['modal.profile.about'].' <span class="text-muted">(HTML is allowed)</span></label>
		<textarea style="height:115px;" id="webabout" class="form-control" name="webabout" placeholder="'.$lang['modal.profile.about'].'">'.$d[$_SESSION['user']]['about'].'</textarea>
		</div>
		</div>
		
		<div class="row">
		<label for="webimg" class="form-label">'.$lang['modal.profile.upload'].'</label>
		<input type="file" name="profileicon" id="webimg" class="form-control" accept=".png"/>
		</div>
		<div class="row mt-2">
		    <div class="col"><button type="submit" name="profileEdit" class="btn btn-primary">'.$lang['btn.save'].'</button></div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'.$lang['btn.close'].'</button>
      </div>
    </div>
  </div>
</div>';

}
# help hover
	public static function helpPrompt($label){
		global $lang;
		return '<i class="fas fa-question-circle" style="cursor:help;" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$lang[$label].'"></i>';
	}
# getSelectedLang
	public static function getLang(){
		global $conf;
		return isset($conf['lang']) ? explode('-',$conf['lang'])[0] : '';
	}

}

?>