<?

namespace Infuso\Cms\Reflex\Plugin;
use \Infuso\Core;

class Log extends Core\Plugin {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

    public function log($message) {
    
        if(!is_array($message)) {
            $message = array(
                "message" => $message,
            );
        }
        
        $message["index"] = get_class($this->component()).":".$this->component()->id();
    
        app()->trace($message);
    }

    public function all() {
        return service("ar")
            ->collection("infuso\\cms\\log\\log")
            ->eq("index", get_class($this->component()).":".$this->component()->id());
    }
    
    public static function factory($component) {
        return new self($component);
    }
    
    public static function name() {
        return "log";
    }
    
    public static function componentClass() {
        return "infuso\\actionrecord\\record";
    }

}
