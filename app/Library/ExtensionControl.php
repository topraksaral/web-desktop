<?php

/**
 * @Author: ToprakSaral
 * @Date:   2019-03-06 13:29:56
 * @Last Modified by:   topraksaral
 * @Last Modified time: 2019-03-14 19:05:02
 */
namespace App\Library;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;


class ExtensionControl {
	public static function isset($ext){
		$path = app_path('/Extensions/'.$ext);
		if(file_exists($path) && !is_file($path)){
			return true;
		}
		return false;
	}

	public static function run($ext){
		if(!self::isset($ext)){
			return "Not Found";
		}

		$core = '\App\Extensions\\'.$ext.'\core\Core';
		$helper = '\App\Extensions\\'.$ext.'\core\Helper';

		$inputs = Input::all();

		View::addLocation(app_path('Extensions'.DIRECTORY_SEPARATOR.$ext.DIRECTORY_SEPARATOR.'view'));

		//$helper = new $helper();

		$loader = AliasLoader::getInstance();
        $loader->alias('EHelper', $helper);

		$core = new $core();
		$core->winId = isset($inputs['winId']) ? $inputs['winId'] : 0;

		unset($inputs['winId']);
		
		return $core->run($inputs);
	}

	public static function getStatic($ext, $type, $fileWay){
		if(pathinfo($fileWay, PATHINFO_EXTENSION) == 'php'){
			return "Not Found";
		}
		if(!self::isset($ext)){
			return "Not Found";
		}

		$fileWay = str_replace('/', DIRECTORY_SEPARATOR, $fileWay);

		$file = app_path('Extensions'.DIRECTORY_SEPARATOR.$ext.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$fileWay);
		//$file = '\App\Extensions\\'.$ext.'\\'.$type.'\\'.$fileWay;
		if(!file_exists($file) || !is_file($file)){
			return "Not Found";
		}

		if(pathinfo($fileWay, PATHINFO_EXTENSION) == 'css'){
			$response = Response::make(file_get_contents($file), 200);
			$response->header('Content-Type', 'text/css');
			return $response;
		}
		if(pathinfo($fileWay, PATHINFO_EXTENSION) == 'js'){
			$response = Response::make(file_get_contents($file), 200);
			$response->header('Content-Type', 'application/javascript');
			return $response;
		}		

		return Response::file($file);
	}

	public static function getExtensionForFile($file){
		if(file_exists($file) && is_dir($file)){
			$ext = '.';
		}else{
			$ext = pathinfo($file, PATHINFO_EXTENSION);
		}
		$settings = self::defaultExtensions();
		if(!isset($settings[$ext])){
			return Response::json([
				'status' => false,
			]);
		}

		if(!self::isset($settings[$ext])){
			return Response::json([
				'status' => false,
			]);
		}

		$set = app_path('Extensions'.DIRECTORY_SEPARATOR.$settings[$ext].DIRECTORY_SEPARATOR.'settings'.DIRECTORY_SEPARATOR.'fileOpenSettings.json');
		if(!file_exists($set)){
			return Response::json([
				'status' => false,
			]);
		}

		$set = json_decode(file_get_contents($set), true);
		$pms = [];
		foreach($set['params'] as $key => $param){
			if($key == 'file_key'){
				$pms[$param] = $file;
				continue;
			}
			$pms[$key] = $param;
		}

		$params = [
			'icon' => route('call.extension.static', ['ext' => $settings[$ext], 'type' => 'image', 'all' => 'icon.png']),
			'ext' => $settings[$ext],
			'title' => $set['title'],
			'resizable' => $set['resizable'],
			'minimizable' => $set['minimizable'],
			'width' => $set['width'],
			'height' => $set['height'],
			'params' => $pms,
		];
		return Response::json([
			'status' => true,
			'params' => $params,
		]);
	}

	private static function defaultExtensions(){
		$settings = file_get_contents(app_path('Settings'.DIRECTORY_SEPARATOR.'defaultExtensions.json'));
		return json_decode($settings, true);
	}
}