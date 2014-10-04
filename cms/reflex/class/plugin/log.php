<?

namespace Infuso\Cms\Reflex\Plugin;

class Log extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

    public function addToClass() {
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
    
    public function factory() {
        return $this;
    }

}
