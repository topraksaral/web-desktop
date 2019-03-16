<?php
namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function getDownload(){
        $file = Input::get('file');

        if($file === null || !file_exists($file) || is_dir($file)){
            return "Dosya Bulunamadı";
        }

        return Response::download($file);
    }

    public function getBackgrounds(){
    	$folder = app_path('Backgrounds');
    	$files = scandir($folder);
    	shuffle($files);
    	
    	$return = [];
    	foreach($files as $file){
    		$ext = pathinfo($file, PATHINFO_EXTENSION);
    		if($ext == 'jpg' || $ext == 'png'){
    			$return[] = route('file.download').'?file='.$folder.DIRECTORY_SEPARATOR.$file;
    		}
    	}

    	return Response::json($return);
    }
}