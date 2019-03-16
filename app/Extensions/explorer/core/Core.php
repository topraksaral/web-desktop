<?php
namespace App\Extensions\explorer\core;

use Illuminate\Support\Facades\Response;

class Core {

	public function run($inputs){
		if(!isset($inputs['operation']) || $inputs['operation'] == 'openFolder'){
			return $this->openFolder($inputs);
		}
		if($inputs['operation'] == 'download'){
			return $this->downloadFile($inputs);
		}
	}


	private function downloadFile($inputs){
		if(!isset($inputs['file']) || !file_exists($inputs['file']) || is_dir($inputs['file'])){
			return "Dosya Bulunamadı";
		}

		return Response::download($inputs['file']);
	}

	private function openFolder($inputs){
		if(!isset($inputs['folder'])){
			$inputs['folder'] = (DIRECTORY_SEPARATOR == '/' ? '/' : 'c:\\');
		}

		if(!file_exists($inputs['folder']) || !is_dir($inputs['folder'])){
			return "Klasör Bulunamadı";
		}

		if(substr($inputs['folder'], -1) != DIRECTORY_SEPARATOR){
			$inputs['folder'] = $inputs['folder'].DIRECTORY_SEPARATOR;
		}

		$files = scandir($inputs['folder']);
		$returnFiles = [];
		$returnFolders = [];
		foreach($files as $file){
			if($file == '.' || $file == '..')
				continue;

			if(!is_dir($inputs['folder'].$file)){
				$returnFiles[] = $file;
				continue;
			}

			$returnFolders[] = $file;
		}

		sort($returnFiles);
		sort($returnFolders);


		foreach($returnFiles as $key => $file){
			clearstatcache();
			$returnFiles[$key] = [
				'type' => 'file',
				'filename' => $file,
			];
		}
		foreach($returnFolders as $key => $file){
			$returnFolders[$key] = [
				'type' => 'folder',
				'filename' => $file,
			];
		}


		$returnFiles = array_merge($returnFolders, $returnFiles);

		$data = [
			'folder' => $inputs['folder'],
			'files' => $returnFiles,
			'winId' => $this->winId,
		];

		return view('explorer', $data);
	}
}

?>