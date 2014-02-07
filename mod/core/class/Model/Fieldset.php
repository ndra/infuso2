<?

namespace Infuso\Core\Model;
use Infuso\Core;

/**
 * Класс коллекции полей
 **/
class Fieldset implements \Iterator {

	private $fields;

	public function __construct($fields) {
		if(!is_array($fields)) {
		    throw new \Exception("Model\Fields bad argument");
		}
		$this->fields = $fields;
	}

    public function rewind() {
		reset($this->fields);
	}

    public function current() {
        return current($this->fields);
    }
    
    public function key() {
		return key($this->fields);
	}

    public function next() {
		return next($this->fields);
	}

    public function valid() {
		return $this->current() !== false;
	}
}
