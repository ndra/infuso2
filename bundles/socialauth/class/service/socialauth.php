<?

namespace Infuso\SocialAuth\Service;
use \Infuso\Core;

/**
 * Служба для авторизации через соцсети
 **/
class SocialAuth extends Core\Service {

    private static $providers;

    public function defaultService() {
        return "socialauth";
    }
    
    public static function buildProviders() {
        if(self::$providers) {
            return;
        }
        self::$providers = array();
        foreach(service("classmap")->classes("Infuso\\SocialAuth\\Provider\\Provider") as $class) {
            self::$providers[$class::name()] = new $class();    
        }
    } 

    public function provider($name) {    
        self::buildProviders();
        return self::$providers[$name];
    }

}
