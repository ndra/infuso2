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
    }
    
    /**
     * Возвращает валидируемую модель
     **/
    public function model() {
        return $this->model;
    }
    
    /**
     * Возвращает объект поля
     **/
    public function field() {
        return $this->field;
    }
    
    /**
     * Возвращает значение поля
     **/
    public function value() {
        return $this->value;
    }
    
    /**
     * Возвращает массив данных модели
     **/
    public function data() {
        return $this->data;
    }
    
    /**
     * Записывает поле в котором произошла ошибка и текст ошибки
     **/
    public function error($name, $text) {
        $this->model()->validationError($name, $text);
        $this->valid = false;
    }
    
    /**
     * Устанавливает флаг валидности = true
     **/
    public function valid() {
        $this->valid = true;
    }
    
    /**
     * Возвращает флаг валидности true / false
     **/
    public function isValid() {
        return $this->valid;
    }


}
