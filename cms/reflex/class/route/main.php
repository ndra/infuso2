<?

namespace Infuso\Cms\Reflex\Route;
use Infuso\Core;

/**
 * Роутер, работающий с базой данных.
 * Отвечает за то что мы видем в каталоге в разделе «Роуты»
 **/

class Main extends \Infuso\Core\Route {

	private static $n = 0;
	
	private static $reg = array();
	
	private static $keys = array();

	public function priority() {
		return 100;
	}
	
	/**
	 * Возвращает коллекцию роутов для текущего домена
	 **/
	public function routesForActiveDomain() {
	    $domain = \Infuso\Cms\Reflex\Model\Domain::active()->id();
	    return \Infuso\Cms\Reflex\Model\Route::all()->where("!`domain` or `domain`='$domain' ");
	}

	/**
	 * Возвращает коллекцию всех роутов
	 * @todo сделать настраиваемым макс количество роутов для перебора
	 **/
	public static function allRoutes() {
	    // Ограничение в 100 роутов нужно чтобы система не впала в кому в случае ошибки :)
	    return self::routesForActiveDomain()->eq("seek","")->limit(100);
	}

	/**
	 * url => action
	 **/
	public function urlToAction($url) {   

        // Пытаемся найти роут прямым запросом в базу          
	    $route = self::routesForActiveDomain()->eq("url", $url->path())->one();
	    if($route->exists()) {
	        $params = $url->query();
	        $params = array_merge($params, $route->pdata("params"));
	        $action = \Infuso\Core\Action::get($route->className(), $route->action(), $params);
	        $action->ar(get_class($route)."/".$route->id());            
	        return $action;
	    }
	    
	    // Не удалось найти прямым запросом - будем перебирать 
	    foreach(self::allRoutes() as $route) {
	    
	        self::$keys = array();
	        $r = $route->data("url");
	        $r = preg_replace_callback("/\<([a-z0-9]+)\:(.*?)\>/s",array("self","replace"), $r);
	        $r = preg_quote($r);
	        $r = "<^".preg_replace_callback("/#(\d+)#/s",array("self","replaceBack"), $r).'$>';
	        
	        if(preg_match($r,$url->path(),$matches,PREG_OFFSET_CAPTURE)) {
	        
	            array_shift($matches);
	            $values = array();
	            
	            foreach($matches as $m) {
	                $key = $m[1];
	                $val = $m[0];
	                if(strlen($val)>strlen($ret[$key])) {
	                    $values[$key] = $val;
					}
	            }
	            
	            if(sizeof(self::$keys)) {
	                $params = array_combine(self::$keys,$values);
				} else {
	                $params = array();
				}

	            $params = array_merge($url->query(),$params);
	            $params = array_merge($params,$route->pdata("params"));
	            $action = Core\Action::get($route->className(),$route->action(),$params);
	            $action->ar(get_class($route)."/".$route->id());
	            return $action;
	        }
	    }
	}

	private function replace($a) {
	    self::$n++;
	    self::$keys[self::$n] = $a[1];
	    self::$reg[self::$n] = $a[2];
	    return "#".self::$n."#";
	}

	private function replaceBack($a) {
	    return "(".self::$reg[$a[1]].")";
	}

	/**
	 * Отображение action => url
	 * Используется системой при построении url
	 **/
	public function actionToUrl($action) {
	
		// Пытаемся получить url по запросу в базу
		// Это сработет для статических url, без параметров
		$seek = $action->hash();

	    $route = self::routesForActiveDomain()->eq("seek",$seek)->one();

	    if($route->exists()) {
	        if($url = $route->actionToUrl($action)) {
				return $url;
			}
        }

		// Если быстрый способ не сработал, перебираем все роуты и ищем подходящий
	    foreach(self::allRoutes() as $route) {
	        if($url = $route->actionToUrl($action)) {
	            return $url;
            }
	    }
	}



}
