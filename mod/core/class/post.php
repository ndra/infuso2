<?

namespace Infuso\Core;

/**
 * Обработчик пост-запросов
 **/
class Post {

    /**
     * Принимает на вод трочку команды
     * Возвращает массив ["class" => ..., "method" => ...] или false если команда неваидная
     **/
    public static function getControllerClass($cmd) {
    
	    $d = strtr($cmd,array(
			"::" => ":",
			"/" => ":"
		));
	    $d = explode(":",$d);
	    $method = array_pop($d);
	    $ns = array();
	    
	    while(sizeof($d)) {
	    
	    	$class = implode("_",$d);
	    	$namespace = "\\".implode("\\",$ns);
	    	$fullClassName = trim($namespace."\\".$class,"\\");
	    	
	    	if(service("classmap")->isSubclassOf($fullClassName, "infuso\\core\\controller")) {
	    	    return array(
	    	        "class" => $fullClassName,
	    	        "method" => $method,
				);
	    	}
	    	
	    	$segment = array_shift($d);
	    	$ns[] = $segment;
	    	
	    }
	    
	    return false;
	    
    }

	/**
	 * Обрабатывает POST-запрос
	 **/
	public function process($p, $files) {
    
	    if(!$cmd = trim($p["cmd"])) {
			throw new \Exception("Пустая команда");
	    }

	    $callback = self::getControllerClass($cmd);

	    // Проверяем теоретическую возможность обработать пост-запрос
	    if(!$callback) {
            throw new \Exception("Команда {$cmd} отклонена: контроллер не найден");
        }
	    
        $class = $callback["class"];
        $method = $callback["method"];
        $obj = new $class;
	        
		if(!call_user_func(array($obj, "postTest"), $p)) {
            throw new \Exception("Команда {$cmd} отклонена: контроллер postTest() вернул false");
        }
        
        if(!$obj->methodExists("post_".$method)) {
            throw new \Exception("Команда {$cmd} отклонена: метод post_{$method} не найден");
        }
                
		return call_user_func_array(array($obj, "post_".$method), array($p, $files));

	}

}
