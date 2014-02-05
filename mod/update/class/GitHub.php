<?

namespace Infuso\Update;

use Infuso\Core;

/**
 * Класс для работы с API github.com
 **/
class GitHub extends \Infuso\Core\Component {

	public function __construct($params) {
	    $this->params($params);
	}
	
	public function owner() {
	    return $this->param("owner");
	}
	
	public function repo() {
	    return $this->param("repo");
	}
	
	public function branch() {
	    return $this->param("branch");
	}
	
	/**
	 * Делает запрос к гитхабу
	 **/
	public function query($url,$params = array()) {
	
	    $params += $this->params();
	
		$url = preg_replace_callback("/\:([a-z]+)/",function($match) use(&$params) {
		    $key = $match[1];
		    return $params[$key];
		},$url);
		
		$file = Core\File::http($url);
		$file->userAgent("Infuso-Update");
		$file->curlParam("CURLOPT_USERPWD", "xxx:x-oauth-basic");
		$file->curlParam("CURLOPT_HTTPAUTH", CURLAUTH_BASIC);
		$json = $file->contents();
		$data = json_decode($json,1);

		if($data["message"]) {
			throw new \Exception($url.": ".$data["message"]."\n".$data["documentation_url"]);
		}
		
		return $data;
		
	}
	
	public function zip() {
	
	    $url = "https://api.github.com/repos/:owner/:repo/:format/:branch";
	
	    $params = $this->params();
	    $params["format"] = "zipball";

		$url = preg_replace_callback("/\:([a-z]+)/",function($match) use(&$params) {
		    $key = $match[1];
		    return $params[$key];
		},$url);

		$file = Core\File::http($url);
		$file->userAgent("Infuso-Update");
		$file->curlParam("CURLOPT_USERPWD", ":x-oauth-basic");
		$file->curlParam("CURLOPT_HTTPAUTH", CURLAUTH_BASIC);
		$data = $file->contents();
		
		$zip = Core\File::tmp()."/1.zip";
		Core\File::get($zip)->put($data);
		$this->extract($zip,"zzz","mod");
		
	}
	
	/**
	 * Извлекает из архива $zip в папку $dest часть, соответствующую пути $path
	 **/
	public function extract($src,$dest,$path) {
	
	    $path = trim($path,"/");
	
	    $zip = new \ZipArchive();
	    $zip->open(Core\File::get($src)->native());
	    
	    $root = "";
	    for($i = 0; $i < $zip->numFiles; $i ++) {
	    	$file = $zip->getNameIndex($i);
	    	$file = explode("/",trim($file,"/"));
	    	array_shift($file);
	    	if(!sizeof($file)) {
	    	    continue;
	    	}
	    	$file = implode("/",$file);
	    	if($file == $path) {
	    	    $root = $zip->getNameIndex($i);
	    	}
	    }
	    
	    for($i = 0; $i < $zip->numFiles; $i ++) {
	    	$file = $zip->getNameIndex($i);
	    	if(strpos($file,$root)===0) {
	    	    $name = $zip->getNameIndex($i);
	    	    $name = substr($name,strlen($root));
	    	    if($name) {
	    	    	$stat = $zip->statIndex($i);
	    	    	if($stat["crc"] != 0) {
	    	    	    $itemDest = Core\File::get($dest."/".$name);
	    	    		Core\File::mkdir($itemDest->up(),1);
	    	    		$itemDest->put($zip->getFromIndex($i));
	    	    	}
	    	    }
	    	}
	    	
	    }
	}


}
