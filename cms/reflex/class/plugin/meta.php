<?

namespace Infuso\Cms\Reflex\Plugin;

class Meta extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

	public function metaObject() {
	}

}
