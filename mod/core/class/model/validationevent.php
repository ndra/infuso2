<?

namespace Infuso\Core\Model;

class ValidationEvent extends \Infuso\Core\Component {

    private $model;
    private $field;
    private $data;
    private $value;
    private $callback;
    private $valid = false;
    
    public function __construct($params) {
        $this->model = $params["model"];
        $this->field = $params["field"];
        $this->value = $params["value"];
        $this->data = $params["data"];
        $this->callback = $params["callback"];
    }
    
    public function model() {
        return $this->model;
    }
    
    public function field() {
        return $this->field;
    }
    
    public function data() {
        return $this->data;
    }
    
    public function exec() {
        return call_user_func($this->callback, $this);
    }
    
    public function error($name, $text) {
        $this->model->validationError($name, $text);
        $this->valid = false;
    }
    
    public function valid() {
        $this->valid = true;
    }
    
    public function isValid() {
        return $this->valid;
    }


}
