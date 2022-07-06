<?php
function Core_head(){
	global $BASEPATH;
	$out = '<script src="'.$BASEPATH.DS.'data'.DS.'plugins'.DS.'Core'.DS.'js'.DS.'core.js" class="CoreJS"></script>';
	return $out;
}
?>