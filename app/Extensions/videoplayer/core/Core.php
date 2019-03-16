<?php
namespace App\Extensions\videoplayer\core;

use Illuminate\Support\Facades\Response;

class Core {

	private $allowedExtensions = [
		'mp4',
	    'mpg',
	    'avi',
	    'mov',
	    'mkv',
	    '3gp',
	    'vmw',
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

		$data = [
			'fileName' => $fileName,
			'current' => $inputs['file'],
		];

		return view('simple', $data);
	}
}

?>