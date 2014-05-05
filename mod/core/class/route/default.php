<?

/**
 * Роут для стандартных урл
 **/
class mod_route_default extends \Infuso\Core\Route {

	public function priority() {
		return -1000;
	}

	public function urlToAction($url) {
	
		$segments = explode("/",trim($url->path(),"/"));
		$classmap = mod::service("classmap");
		$rest = array();

		do {

			$class = implode("\\",$segments);
		    
		    if($classmap->testClass($class,"infuso\\core\\controller")) {
		    
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
		$ret = "/".strtr($action->className(),array("\\" => "/"))."/".$action->action()."/";
		foreach($action->params() as $key => $val) {
		    $ret.= "$key/$val/";
		}
		return $ret;
	}

}
