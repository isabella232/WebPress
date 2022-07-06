<?php
class Files{
	protected function __construct(){
		
	}
	public static function renameFile($old, $new){
		return rename($old, $new);
	}
	public static function upload($name, $loc, $rename=null){
					$target_dir = $loc;
$target_file = $target_dir . basename($_FILES[$name]["name"]);
$uploadOk = 1;
	if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
			if($rename!==null){
				if(Files::renameFile($target_file, $target_dir.$rename)){
			echo "<div class='alert alert-success' role='alert'>The file ". htmlspecialchars( basename( $_FILES[$name]["name"])). " has been uploaded.</div>";
			}else{
				echo "<div class='alert alert-danger' role='alert'>Failed to rename</div>";
			}
			}else{
			echo "<div class='alert alert-success' role='alert'>The file ". htmlspecialchars( basename( $_FILES[$name]["name"])). " has been uploaded.</div>";	
			}
		} else {
		echo "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your file.</div>";
		}
	}
}
	public static function remove($name, $loc){
		return unlink($loc.$name) ? true : false;
	}
	public static function catche($dir)
	{
		$ffs = scandir($dir);
		foreach ($ffs as $ff) {
			if ($ff != '.' && $ff != '..') {
				if (file_exists($dir.'/'.$ff)) {
					unlink($dir.'/'.$ff);
				}
				if (is_dir($dir . '/' . $ff)) {
					Files::catche($dir . '/' . $ff);
				}
			}
		}
		return true;
	}
	public static function copyFolder($src, $dst) {
   // open the source directory
    $dir = opendir($src); 
  
    // Make the destination directory if not exist
    @mkdir($dst); 
  
    // Loop through the files in source directory
    while( $file = readdir($dir) ) { 
  
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) 
            { 
  
                // Recursively calling custom copy function
                // for sub directory 
                Files::copyFolder($src . '/' . $file, $dst . '/' . $file); 
  
            } 
            else { 
                copy($src . '/' . $file, $dst . '/' . $file); 
            } 
        } 
    } 
  
    closedir($dir);
	}
	public static function copyFile($start, $end){
		return copy($start, $end) ? true : false;
	}
	public static function Scan($path, $removeDots=true){
		$dirs = $removeDots ? array_diff(scandir($path), ['.','..']) : scandir($path);
		return $dirs;
	}
	public static function getFileData($path){
		return file_exists($path) ? nl2br(file_get_contents($path)) : '';
	}
	
	public static function scanXML($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;
    foreach($ffs as $ff){
			echo '<url><loc>'.str_replace('//','\\',$dir.'/'.$ff);
        if(is_dir($dir.'/'.$ff)) str_replace('//','\\',$dir.'/'.Files::scanXML($dir.'/'.$ff).'\\');
		echo '</loc><changeferq>daily</changeferq></url>';
    }
   
	}
public static function sizeFormat($bytes){ 
	$kb = 1024;
	$mb = $kb * 1024;
	$gb = $mb * 1024;
	$tb = $gb * 1024;

	if (($bytes >= 0) && ($bytes < $kb)) {
	return $bytes . 'B';
	} elseif (($bytes >= $kb) && ($bytes < $mb)) {
		return ceil($bytes / $kb) . 'KB';
	} elseif (($bytes >= $mb) && ($bytes < $gb)) {
		return ceil($bytes / $mb) . 'MB';
	} elseif (($bytes >= $gb) && ($bytes < $tb)) {
		return ceil($bytes / $gb) . 'GB';
	} elseif ($bytes >= $tb) {
		return ceil($bytes / $tb) . 'TB';
	} else {
		return $bytes . 'B';
	}
	}
public static function folderSize($dir){
	$count_size = 0;
	$count = 0;
	$dir_array = scandir($dir);
	foreach($dir_array as $key=>$filename){
		if($filename!=".." && $filename!="."){
		if(is_dir($dir."/".$filename)){
			$new_foldersize = Files::foldersize($dir."/".$filename);
			$count_size = $count_size+ $new_foldersize;
			}else if(is_file($dir."/".$filename)){
			$count_size = $count_size + filesize($dir."/".$filename);
			$count++;
			}
	}
	}
		return $count_size;
	} 
	
}
?>