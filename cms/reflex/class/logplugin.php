<?

namespace Infuso\Cms\Reflex;

class LogPlugin extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

    public function addToClass() {
    }

    public function log($text) {
        service("ar")->create("infuso\\cms\\log\\log", array(
            "text" => $text,
            "index" => get_class($this->component()).":".$this->component()->id(),
        ));
    }

    public function getLog() {
        return service("ar")
            ->collection("infuso\\cms\\log\\log")
            ->eq("index", get_class($this->component()).":".$this->component()->id());
    }

}
