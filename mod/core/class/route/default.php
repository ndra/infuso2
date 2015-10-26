<?

/**
 * Роут для стандартных урл
 **/
class mod_route_default extends \Infuso\Core\Route {

	public function priority() {
		return -1000;
	}

	public function urlToAction($url) {
	
		$segments = explode("/",trim(strtolower($url->path()),"/"));
		$controllers = service("classmap")->classmap("controllers");
		$rest = array();

		do {

			$controller = implode("/",$segments);
			
			$class = $controllers[$controller];
			
		    if($class) {
		    
		        $action = array_shift($rest);
		        if($action === null) {
		            $action = "index";
		        }

		        $params = $_GET;
				while (count($rest)) {
				    list($key,$value) = array_splice($rest, 0, 2);
				    $params[$key] = $value;
				}
				
				return \infuso\core\action::get($class,$action,$params);

		    }
		    
		    $segment = array_pop($segments);
		    array_unshift($rest,$segment);
		    
		} while (sizeof($segments));
		
	}

	public function actionToUrl($action) {
	
	    $controllers = service("classmap")->classmap("controllers");
	    $class = array_search($action->className(), $controllers);
	
		$ret = "/".strtr($class,array("\\" => "/"));
		
		if($action->action() != "index" || sizeof($action->params())) {
		    $ret.= "/".$action->action();
		}
		
		$ret.= "/";
		
		foreach($action->params() as $key => $val) {
		    $ret.= "$key/$val/";
		}
		
		return $ret;
	}

}
