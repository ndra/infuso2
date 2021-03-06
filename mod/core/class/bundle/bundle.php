<?

namespace Infuso\Core\Bundle;
use infuso\core\file as file;
use infuso\core\mod as mod;

/**
 * Класс, реализующий бандл
 **/
class Bundle extends \Infuso\Core\Component {

	private $path = null;
	
	public function __construct($path) {
		$this->path = $path;
	}

	public function path() {
	    return File::get($this->path);
	}

	/**
	 * Возвращает массив конфигурации бандла
	 **/
	public function conf() {
	
	    $file = file::get($this->path()."/.infuso");
	    if($file->exists()) {
		    $data = file::get($this->path()."/.infuso")->data();
			$conf = service("yaml")->read($data);
		} else {
		    $conf = file::get($this->path()."/info.ini")->ini(true);
			$conf["public"] = $conf["mod"]["public"];
			$conf["leave"] = $conf["mod"]["leave"];
		}
		
		foreach(func_get_args() as $key) {
			$conf = $conf[$key];
		}
		
		return $conf;
	}
	
	/**
	 * Возвращает признак существования бандла
	 **/
	public function exists() {
	
	    if(\infuso\core\file::get($this->path()."/.infuso")->exists()) {
	        return true;
	    }

		if(\infuso\core\file::get($this->path()."/info.ini")->exists()) {
	        return true;
	    }
	    
	    return false;
	}

	/**
	 * Возвращает список публичных директорий бандла
	 **/
	public function publicFolders() {

		$ret = array();
	    $conf = $this->conf();
	    $public = is_array($conf["public"]) ? $conf["public"] : array();
	    foreach($public as $folder) {
			$ret[] = (string) file::get($this->path()."/".$folder);
	    }
	    return $ret;

	}
	
	/**
	 * Возвращает путь к классам модуля
	 **/
	public function classPath() {
	    return file::get($this->path()."/class/");
	}

}
