<?

namespace infuso\core;

/**
 * Базовый класс для служб
 **/
class service extends controller {

    private static $serviceInstance = null;

    public function defaultService() {
        return false;
    }
    
    public static function isSingletonService() {
        return false;
    }
    
    public static function serviceFactory() {
    
        $class = get_called_class();
    
        if($class::isSingletonService()) {
	        if(!self::$serviceInstance) {
				self::$serviceInstance = new $class;
			}
	        return self::$serviceInstance;
        } else {
	        return new $class;
        }
    }

}
