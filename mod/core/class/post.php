<?

namespace Infuso\Core;

/**
 * Обработчик пост-запросов
 **/
class Post {

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
	    	
	    	if(service("classmap")->testClass($fullClassName,"infuso\\core\\controller")) {
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
	public function process($p,$files,&$status=null) {
	
		$status = false;

	    if(!$cmd = trim($p["cmd"])) {
			return;
	    }

	    $callback = self::getControllerClass($cmd);

	    // Проверяем теоретическую возможность обработать пост-запрос
	    if($callback) {
	    
	        $class = $callback["class"];
	        $method = $callback["method"];

	        $obj = new $class;
	        
		    if(call_user_func(array($obj,"postTest"),$p)) {
			    if($obj->methodExists("post_".$method)) {
			        $status = true;
			        try {
			        
			            // Вызываем сообщение
			            mod::fire("mod_beforecmd",array(
			                "params" => $p,
						));

						// Выполняем
			        	$ret = call_user_func_array(array($obj,"post_".$method),array($p,$files));
			        	
			        } catch(mod_userLevelException $ex) {
			            app()->msg($ex->getMessage(),1);
			        }
			        return $ret;
			    }
			}
			
		}

	    $cmd = superadmin::check() ? $cmd : "";
	    app()->msg("Команда $cmd отклонена",1);
	}

}
