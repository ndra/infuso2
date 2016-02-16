<?

namespace Infuso\Cms\Reflex;
use Infuso\Core;
use User;

class Keeper {

    private static $sessionKey = "9YOHyVWDBwJX";

    public static function set($class, $id, $method) {
    
        $class = strtolower($class);
    
        $s = app()->session(self::$sessionKey);
        if(!$s) {
            $s = array();
        }
        $s[$class.":".$id] = $method;
        app()->session(self::$sessionKey, $s);
    }
    
    public static function get($class, $id) {
    
        $class = strtolower($class);
    
        $s = app()->session(self::$sessionKey);
        if(!$s) {
            $s = array();
        }
        $method = $s[$class.":".$id];
        return $method;
    }

}