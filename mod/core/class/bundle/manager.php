<?

namespace infuso\core\bundle;

/**
 * Служба управления бандлами
 **/
class manager extends \infuso\core\service {

	public function defaultService() {
		return "bundle";
	}
	
	private static $bundles = array();
	
	public function all() {
	    if(!self::$bundles) {
			self::$bundles = self::allWithoutCache();
	    }
	    return self::$bundles;
	}
	
	/**
	 * Возвращает список всех бандлов
	 * @todo ускорить работу
	 **/
	public function allWithoutCache() {
	
	    $bundles = array();
	    $manager = $this;
	    
		$exclude = array(
			(string) \mod::app()->varPath(),
			(string) \mod::app()->publicPath(),
			(string) \mod::app()->confPath(),
		);

	    $scan = function($path) use (&$scan, &$bundles, $manager, $exclude) {
	    
	        if($path=="/.git") {
	            return;
	        }
	        
	        if(in_array($path,$exclude)) {
	            return;
	        }
	        
	        // Максимальная глубина, на которой искать модули
	        $path2 = explode("/",$path);
	        if(sizeof($path2) > 3) {
	            return;
	        }

            $bundle = $manager->bundle($path);
			$leave = array();
			if($bundle->exists()) {
				$bundles[] = $bundle;
				$leave = $bundle->leave();
			}
	    
	        foreach(\infuso\core\file::get($path)->dir()->folders() as $folder) {
				if(!in_array((string)$folder,$leave)) {
				    $scan($folder);
				}
	        }
	    
	    };
	    
		$scan("/");
		
		return $bundles;
	
	}
	
	public function bundle($bundle) {
	    return new bundle($bundle);
	}

}
