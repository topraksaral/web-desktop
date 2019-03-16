<?php
namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Library\ExtensionControl as EC;

class ExtensionController extends Controller
{
    public function postCheckExtension($ext = null){

        if(!EC::isset($ext)){
        	return [
	            'status' => false,
	            'message' => 'Eklenti Bulunamadı.',
	        ];
        }

    	return [
            'status' => true,
            'message' => '',
        ];
    }

    public function runExtension($ext = null){
        return Ec::run($ext);
    }

    public function getExtensionStaticFile($ext, $type, $file){
        return Ec::getStatic($ext, $type, $file);
    }

    public function postExtensionForFile(){
        $file = Input::get('file');
        
        return EC::getExtensionForFile($file);
    }
}