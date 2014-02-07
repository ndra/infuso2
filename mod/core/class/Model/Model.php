<?

namespace Infuso\Core\Model;
use Infuso\Core;

/**
 * Модель
 **/
abstract class Model extends Core\Controller {

	/**
	 * Данные модели
	 **/
    private $data = array();
    
    /**
     * Поля модели (массив)
     **/
    private $fields = null;
    
    /**
     * Набор полей (объект класса Model\Fieldset)
     **/
    private $fieldset = array();

    /**
     * Возвращает коллекцию полей модели
     **/
    public final function fields() {

        Core\Profiler::beginOperation("reflex","fields",get_class($this));

        if(!$this->fieldset) {

            $modelFields = $this->modelFieldBuffered();
            foreach($modelFields as $name => $field) {
                $this->field($name);
            }

            $this->fields = new Fieldset($this->fields);
        }
        
        Core\Profiler::endOperation();

        return $this->fields;
    }

    /**
     * @return Возвращает поле по id
     **/
    public final function field($name) {
    
        if(!$this->fields[$name]) {

            $fields = $this->modelFieldBuffered();
            $field = $fields[$name];
            
			if($field) {
			
	            $field = clone $field;
	            $field->setModel($this);
	            $this->fields[$name] = $field;
	            
            } else {
            
                $field = Field::getNonExistent();
                $field->setModel($this);
                return $field;
            
            }

        }
        
        return $this->fields[$name];
		
    }

     /**
      * Фабрика полей
      * Метод должен быть определен в дочернем классе
      **/
     abstract protected function fieldFactory($name);
     
     /**
      * Возвращает массив с именами полей
      * Метод должен быть определен в дочернем классе
      **/
     abstract protected function fieldNames();

    /**
     * Устанавливает начальные данные модели
     * Вызывается при создании модели
     * @todo рефакторинг скорости
     **/
    public final function setInitialData($initialData=array()) {

        if(!is_array($initialData)) {
            $initialData = array();
        }

        $this->data = $initialData;

    }

    /**
     * Враппер для доступа к даным
     **/
    public final function data($key=null,$val=null) {

        // Если параметров 0 - возвращаем массив с данными
        if(func_num_args()==0) {
            return $this->data;
        }

        // Если параметров 1 - возвращаем значение поля
        if(func_num_args()==1) {
            return $this->data[$key];
        }

        // Если два параметра - меняем значение
        elseif(func_num_args()==2) {
            $this->field($key)->value($val);
        }
    }

    /**
     * Передает в модель массив данных
     * Аргументом может быть какже экземпляр класса mod_fieldset
     **/
    public function setData($data) {

        if(is_array($data)) {
            foreach($data as $key=>$val) {
                $this->data($key,$val);
            }
        }

        if(is_object($data) && get_class($data)=="mod_fieldset") {
            foreach($data as $field) {
                $this->data($field->name(),$field->value());
            }
        }

    }

    /**
     * Возвращает данные в формате, зависящем от типа поля.
     * Для файлов - объект файла, для внешнего ключа - объект reflex и т.д.
     **/
    public final function pdata($key) {
        return $this->field($key)->pvalue();
    }

    /**
     * Возвращает данные в человекопонятной форме
     **/
    public final function rdata($key) {
        return $this->field($key)->rvalue();
    }

}
