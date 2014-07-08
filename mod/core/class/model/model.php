<?

namespace Infuso\Core\Model;
use Infuso\Core;

/**
 * Модель
 **/
abstract class Model extends Core\Controller {

	/**
	 * Начальные данные модели
	 **/
    private $initialData = array();
    
	/**
	 * Измененные данные
	 **/
    private $changedData = array();
    
    /**
     * Поля модели (массив)
     **/
    private $fields = null;

    public function __construct($initialData) {
        $this->initialData = $initialData;
    }

    /**
     * Возвращает коллекцию полей модели
     **/
    public final function fields() {
		$fieldset = new Fieldset($this,$this->fieldNames());
		return $fieldset;
    }

    /**
     * @return Возвращает поле по имени
     **/
    public final function field($name) {
        $ret = $this->fieldFactory($name);
        if(!$ret) {
            $ret = Field::getNonExistent();
        }
        $ret->setModel($this);
        return $ret;
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
     * Враппер для доступа к даным
     * @todo рефакторить скорость для дефолтных полей
     **/
    public final function data($key=null,$val=null) {

        // Если параметров 0 - возвращаем массив с данными
        if(func_num_args()==0) {
        
            // Берем массив с исходными данными и мержим его с измененными данными
            $ret = $this->changedData + $this->initialData;
            
            // Добавляем дефолтные значения для несуществующих индексов
            foreach($this->fieldNames() as $name) {
                if(!array_key_exists($name,$ret)) {
                    $ret[$name] = $this->field($name)->defaultValue();
                }
            }
            
            return $ret;
        }

        // Если параметров 1 - возвращаем значение поля
        if(func_num_args()==1) {
        
            if(array_key_exists($key,$this->changedData)) {
                return $this->changedData[$key];
            }
            
            if(array_key_exists($key,$this->initialData)) {
				return $this->initialData[$key];
			}
			
			return $this->field($key)->defaultValue();
        }

        // Если два параметра - меняем значение
        elseif(func_num_args()==2) {                            
            $field = $this->field($key);
            $preparedValue = $field->prepareValue($val);
            $this->changedData[$key] = $preparedValue;
            $this->handleRecordDataChanged();
        }
    }
    
    abstract function handleRecordDataChanged();

    /**
     * Передает в модель массив данных
     * @todo сделать чтобы в качестве данных можно было передавать модель или филдсет
     **/
    public final function setData($data) {

        if(is_array($data)) {
            foreach($data as $key=>$val) {
                $this->data($key,$val);
            }
        }

    }
    
    /**
     * Возвращает исходные данные модели (до изменения)
     **/
    public final function initialData() {
        return $this->initialData;
    }
    
	/**
     * Устанавливает исходные данные модели
     **/
    public final function setInitialData($data) {
    
        if($data === null) {
            $data = array();
		}
    
        if(!is_array($data)) {
            throw new \Exception("Model::setInitialData() first argument must be array, ".gettype($data)." given");
        }
    
        $this->changedData = array();
        $this->initialData = $data;
    }
    
    public function revertInitialData() {
        $this->changedData = array();
    }
    
    public final function isFieldChanged($key) {
        return array_key_exists($key, $this->changedData);
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
