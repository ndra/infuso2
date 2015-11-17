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
    
    /**
     * Массив с ошибками валидации
     * Будет заполнен при вызове метода validate, если взоникнут ошибки
     **/        
    private $validationErrors = array();

    public function __construct($initialData = array()) {
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
     * Описание таблицы записи с учетом поведений
     * @todo сделать кэширование
     **/
    public static function modelExtended() {
    
        $class = get_called_class();
        
        $ret = $class::model();
        
        $behaviours = \Infuso\Core\BehaviourMap::getBehavioursForMethod($class, "model");        
        
        foreach($behaviours as $behaviour) {
            $data = $behaviour::model();
            if(array_key_exists("fields", $data)) {
                foreach($data["fields"] as $fieldData) {
                    $ret["fields"][] = $fieldData;
                }
            }
        }
        return $ret;
    }

    /**
     * Фабрика полей
     * Возвращает поле по его имени
     * @todo сделать кэширвоанеи работы
     **/
    public function fieldParams($name) {
		$model = $this->modelExtended();
        if(is_array($model["fields"])) {
    		foreach($model["fields"] as $fieldDescr) {
    		    if($fieldDescr["name"] == $name) {
    		        return $fieldDescr;
    		    }
    		}
        }
    }

    /**
     * @return Возвращает поле по имени
     **/
    public final function field($name) {
    
        $fieldData = $this->fieldParams($name);
        if($fieldData) {

			// Учитываем сценарии
	        if($scenario = $this->scenario()) {

	            $found = false;
	            foreach($this->scenarioData() as $scenarioFieldData) {
	                if($scenarioFieldData["name"] == $name) {
	                    foreach($scenarioFieldData as $key => $val) {
	                        $fieldData[$key] = $val;
	                    }
		                $found = true;
		                break;
	                }
	            }
	            if(!$found) {
	                $fieldData["editable"] = false;
	            }
	        }
	        
	        $ret = Field::get($fieldData);
        
        } else {
			$ret = Field::getNonExistent();
        }
        
        $ret->setModel($this);
        return $ret;
	}
	
    /**
     * Возвращает массив имен полей модели
     * @todo сделать кэширвоанеи работы
     **/
    public function fieldNames() {
        $names = array();
        $model = $this->modelExtended();

        if(!is_array($model["fields"])) {
            throw new \Exception("Model[fields] must be Array in ".get_class($this));
        }

		foreach($model["fields"] as $fieldDescr) {
		    $names[] = $fieldDescr["name"];
		}
		return $names;
    }
    
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
        elseif(func_num_args() == 2) {
            $field = $this->field($key);
            
            // Подготавливаем новое и старое значение, чтобы корректно сравнить их
            $preparedValue = $field->prepareValue($val);
            $oldPreparedValue = $field->prepareValue($field->value());
            
			// Если старое и новое значения совпадают, ничего не делаем
            if($preparedValue != $oldPreparedValue) {
	            $this->changedData[$key] = $preparedValue;
	            $this->handleModelDataChanged();
            }
            
            return $this;
        }
    }
    
    abstract public static function model();
    
    abstract function handleModelDataChanged();

    /**
     * Передает в модель массив данных
     * В качестве данных можно было передавать модель или филдсет
     **/
    public final function setData($data) {
        if(is_array($data)) {
            foreach($data as $key => $val) {
                $this->data($key, $val);
            }
        } elseif(is_object($data) && is_subclass_of($data, "infuso\\core\\model\\model")) {
            foreach($data->data() as $key => $val) {
                $this->data($key, $val);
            }
        } else {
            throw new \Exception("setData bad argument");
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

        foreach($data as $key => $val) {
            $field = $this->field($key);
            $data[$key] = $field->prepareValue($val);
        }

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

    /**
     * Добавляет ошибку валидации
     **/         
    public function validationError($fieldName, $errorText) {
        $this->validationErrors[] = array(
            "name" => $fieldName,
            "text" => $errorText,
        );
    }
    
    /**
     * Возврашает массив с ошибками валидации
     **/         
    public final function getValidationErrors() {
        return $this->validationErrors;
    }
    
    /**
     * Проверяет данные на валидность
     **/         
    public final function validate($data) {
        foreach($this->fields() as $field) {
            if(!$field->validate($data[$field->name()], $data)) {
                $this->validationError($field->name(), $field->validationErrorText());
                return false;
            }
        }
        return true;
    }
    
    /**
     * Возвращает / устанавливает сценарий
     **/
    public function scenario($scenario = null) {
        if(func_num_args() == 0) {
        	return $this->scenario;
        } elseif(func_num_args() == 1) {
            $this->scenario = $scenario;
            return $this;
        }
        throw new \Exception("Model::scenario wrong arguments number");
    }
    
    /**
     * Возвращает массив данных активного сценария
     **/
	public function scenarioData() {
	    $scenario = $this->scenario();
	    $model = $this->model();
		$scenarioData = $model["scenarios"][$scenario];
		return $scenarioData;
	}
	
	/**
	 * заполняет данные модели из массива $data
	 * Данные предварительно валидируются в соответствии с активнм сценарием
	 * Будут заполнены только те поля, которые отмечены как редактируемые в сценарии
	 **/
	public function fill($data) {    
	
		if(!$this->validate($data)) {
		    throw new \Exception("Model::fill() validation failed");
		}
		
		foreach($this->fields()->editable() as $field) {
		    $this->data($field->name(),$data[$field->name()]);
		}
		
		return $this;
	
	}

}
