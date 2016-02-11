<?

namespace Infuso\CMS\Profiler;

class Handler extends \Infuso\Core\Controller implements \Infuso\Core\Handler {

    /**
     * @handler = infuso/beforeAction
     **/
    public function beforeAction() {
        if(\Infuso\Core\Superadmin::check()) {
            \Infuso\Template\Lib::modJS();
            app()->tm()->script("SoS4LQkVRF8Q = '".\Infuso\Core\Profiler::id()."'");
            app()->tm()->css(self::inspector()->bundle()->path()."/res/css/profiler.css");    
            app()->tm()->js(self::inspector()->bundle()->path()."/res/js/profiler.js");
        }         
    }
    
    /**
     * @handler = infuso/afterActionSys
     **/
    public function afterActionSys() {
        if(\Infuso\Core\Superadmin::check()) {
            $key = \Infuso\Core\Profiler::id();
            $data = \Infuso\Core\Profiler::getData();
            service("cache")->set($key, $data);
        }
    }

}
