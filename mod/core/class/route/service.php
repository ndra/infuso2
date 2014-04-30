<?

namespace Infuso\Core\Route;
use Infuso\Core;

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

    public final function urlToActionNocache($url) {

        Core\profiler::beginOperation("url","forward",$url);

        if(is_string($url)) {
            $url = mod_url::get($url);
        }

        if(strtolower($url->path())=="/mod") {
            core\profiler::endOperation();
            return core\mod::action("Infuso\\Core\\Console");
        }

        $routers = core\mod::service("classmap")->classmap("routes");
        
        foreach($routers as $router) {
            if($action = call_user_func(array($router,"urlToAction"),$url)) {
                Core\Profiler::endOperation();
                return $action;
            }
        }

        Core\Profiler::endOperation();
        return new Action();
    }

	/**
	 * Преобразует отъект класса Url в объект класса Action
	 **/
    public function urlToAction($url) {

        $key = "action-to-url/".$url;
        $serializedAction = Core\Mod::Service("cache")->get($key);

        if(!$serializedAction) {
        
            $action = $this->urlToActionNocache($url);

            $serializedAction = json_encode(array(
				$action->className(),
				$action->action(),
				$action->params(),
				$action->ar(),
			));
            Core\Mod::Service("cache")->set($key,$serializedAction);

            return $action;

        } else {

            list($class,$method,$params,$ar) = json_decode($serializedAction,true);
            $action = Core\Mod::action($class,$method,$params);
            $action->ar($ar);

            return $action;

        }
        
		return new Core\Action();

    }

    /**
     * @return Возвращает url экшна
     * url Кэшируется на сутки
     * @todo сделать настройки кэширвоания url
     **/
    public final function actionToUrl($action) {

        Core\Profiler::beginOperation("url","build",$action->canonical());

        if(true) {

            // Урл кэшируются на день
            $hash = "action-url:".$action->hash().ceil(time()/3600/24);

            if($url = Core\Mod::service("cache")->get($hash)) {
                Core\Profiler::endOperation();
                return $url;
            }
        }


        $url = $this->actionToUrlNocache($action);

        if(true) {
            Core\Mod::service("cache")->set($hash,$url);
        }

        Core\Profiler::endOperation();

        return $url;

    }

    /**
     * Возвращает url экшна
     * результат не кэшируется
     **/
    public function actionToUrlNocache($action) {

        $routes = Core\Mod::service("classmap")->classmap("routes");
        foreach($routes as $router) {
            if($url = call_user_func(array($router,"actionToUrl"),$action)) {
                return $url;
            }
        }
    }

}
