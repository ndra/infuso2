<?

namespace infuso\core\route;
use infuso\core;

class service extends \infuso\core\service {

	public function defaultService() {
		return "route";
	}

	/**
	 * Очищает кэш url
	 **/
	public function clearCache() {
	    $ret = mod::service("cache")->clearByPrefix("action-url:");
	    if(!$ret) {
	        mod::service("cache")->clear();
	    }
	}

    public final function forwardTest($url) {

        core\profiler::beginOperation("url","forward",$url);

        if(is_string($url)) {
            $url = mod_url::get($url);
        }

        if($url->path()=="/mod") {
            core\profiler::endOperation();
            return core\mod::action("Infuso\\Core\\Console");
        }

        $routers = core\mod::service("classmap")->classmap("routes");
        
        foreach($routers as $router) {
            if($callback = call_user_func(array($router,"forward"),$url)) {
                \infuso\core\profiler::endOperation();
                return $callback;
            }
        }
    }

	/**
	 * Преобразует отъект класса Url в объект класса Action
	 **/
    public function urlToAction($url) {

        $key = "action-to-url/".$url;
        $serializedAction = Core\Mod::Service("cache")->get($key);

        if(!$serializedAction) {
        
            $action = $this->forwardTest($url);
            if($action) {
                $serializedAction = json_encode(array(
					$action->className(),
					$action->action(),
					$action->params(),
					$action->ar(),
				));
                Core\Mod::Service("cache")->set($key,$serializedAction);
            }
            return $action;

        } else {

            list($class,$method,$params,$ar) = json_decode($serializedAction,true);
            $action = Core\Mod::action($class,$method,$params);
            $action->ar($ar);

            return $action;

        }

    }

    public function actionToUrl() {
    }

}
