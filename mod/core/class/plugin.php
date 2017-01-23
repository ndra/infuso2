<?

namespace Infuso\Core;

abstract class Plugin {

    abstract public static function componentClass();
    
    abstract public static function factory($component);
    
    abstract public static function name();
    
}
