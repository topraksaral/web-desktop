<?php
namespace App\Extensions\explorer\core;

class Helper {
	public static function getSizeHumanity($fileSize, $decimals = 2){
		$sz = 'BKMGTP';
		$factor = floor((strlen($fileSize) - 1) / 3);
		return sprintf("%.{$decimals}f", $fileSize / pow(1024, $factor)) . @$sz[$factor];
	}

	public static function getIcon($file = null){
		if($file === null){
			return '<span class="icon folder full"></span>';
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);

		return '<span class="icon file f-'.$ext.'">.'.$ext.'</span>';

		if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'jpe' || $ext == 'png' || $ext == 'gif' || $ext == 'mp4' || $ext == 'mpg' || $ext == 'mov' || $ext == 'mkv'){

		}
	}

	public static function openFolder($file){
		if(!file_exists($file)){
			return '#';
		}
		if(!is_dir($file)){
			return '#';
		}

		return route('call.extension', ['ext' => 'explorer']).'?folder='.$file;
	}

	public static function getUpFolder($current){
		$count = substr_count($current, DIRECTORY_SEPARATOR);
		if($count < 2){
			return '#';
		}

		$explode = explode(DIRECTORY_SEPARATOR, $current);

		$return = '';
		foreach($explode as $key => $item){
			if(count($explode)-3 < $key){
				break;
			}
			$return .= $item.DIRECTORY_SEPARATOR;
		}

		return route('call.extension', ['ext' => 'explorer']).'?folder='.$return;
	}
}
?>