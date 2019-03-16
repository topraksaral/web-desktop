<?php
namespace App\Extensions\imageviewer\core;

use Illuminate\Support\Facades\Response;

class Core {

	private $allowedExtensions = [
		'jpg',
		'jpeg',
		'jpe',
		'png',
		'gif',
		'bmp',
	];

	public function run($inputs){
		if(!isset($inputs['operation']) || $inputs['operation'] == 'simple'){
			return $this->openFile($inputs);
		}
	}

	private function openFile($inputs){
		if(!isset($inputs['file']) || !file_exists($inputs['file']) || is_dir($inputs['file'])){
			return "Dosya Bulunamadı";
		}

		if(!in_array(pathinfo($inputs['file'], PATHINFO_EXTENSION), $this->allowedExtensions)){
			return "Dosya Formatı Geçersiz";
		}

		$fileName = basename($inputs['file']);

		$folder = str_replace($fileName, '', $inputs['file']);
		$files = scandir($folder);
		sort($files);

		$back = false;
		$find = false;
		$next = false;
		foreach($files as $file){
			if(!is_dir($folder.$file)){
				if($file == $fileName){
					$find = true;
					continue;
				}
				if(in_array(pathinfo($file, PATHINFO_EXTENSION), $this->allowedExtensions)){
					if($find){
						$next = $folder.$file;
						break;
					}
					$back = $folder.$file;
				}
			}
		}

		$data = [
			'fileName' => $fileName,
			'back' => $back,
			'current' => $inputs['file'],
			'next' => $next,
		];

		return view('simple', $data);
	}
}

?>