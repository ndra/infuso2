<?

namespace Infuso\Core\Model;
use Infuso\Core;

/**
 * Класс коллекции полей
 **/
class Fieldset implements \Iterator {

	private $fields;
	private $model;

	public function __construct($model,$fields) {
	
		if(!is_subclass_of($model,"Infuso\\Core\\Model\\Model")) {
		    throw new \Exception("Model\Fields bad first argument");
		}

		if(!is_array($fields)) {
		    throw new \Exception("Model\Fields bad second argument");
		}
		
		$this->fields = $fields;
		$this->model = $model;
	}

    public function rewind() {
		reset($this->fields);
	}

    public function current() {
        $name = current($this->fields);
        if($name !== false) {
        	return $this->model->field($name);
        }
        return false;
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
