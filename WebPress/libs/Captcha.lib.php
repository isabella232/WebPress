<?php
class Captcha
{
        public static function createCaptcha($w=200, $h=38, $bgr=128, $bgg=128, $bgb=128, $cr=0, $cg=0, $cb=0, $size=20, $angle=0){     
		global	$basepath;	
		$out = ''; 		
		$out .= '<div class="input-group mb-3">
<input class="form-control" type="text" id="captcha" name="captcha" required="true" aria-describedby="captcha"/>
  <span class="input-group-text" id="captcha"><img src="../libs/captcha/img.php?captcha=w-'.$w.'+h-'.$h.'+bgr-'.$bgr.'+bgg-'.$bgg.'+bgb-'.$bgb.'+cr-'.$cr.'+cg-'.$cg.'+cb-'.$cb.'+size-'.$size.'+angle-'.$angle.'" id="captchaImg"/></span>
</div>';
			return $out;
        }
		public static function checkCaptcha($code){
				if($code===$_SESSION['captcha_code']){
				return true;
				}else{
					return false;
				}
		}
}
	

?>