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
    private $initialDataRaw = array();
    
	/**
	 * Измененные данные
	 **/
    private $changedDataRaw = array();
    
    private $preparedData = array();
    
    /**
     * Поля модели (массив)
     **/
    private $fields = null;
    
    /**
     * Массив с ошибками валидации
     * Будет заполнен при вызове метода validate, если взоникнут ошибки
     **/        
    private $validationErrors = array();

    public function __construct($initialDataRaw = array()) {
        $this->initialDataRaw = $initialDataRaw;
    }

    /**
     * Возвращает коллекцию полей модели
     **/
    public final function fields() {
		$fieldset = new Fieldset($this, $this->fieldNames());
		return $fieldset;
    }
    
    /**
     * Описание таблицы записи с учетом поведений
     * Данные кэшируются
     **/
    public static function modelExtended($scenario) {
    
        $class = get_called_class();
    
        $cacheKey = "system/model/".$class.":".$scenario; 
        $cache = service("cache");
        $model = $cache->get($cacheKey);
        
        if(!$model) {
        
            $model = $class::model();
            
            // Добавляет в модель $model поле $newField
            // Если поле с таким именем есть в модели, новые данные заменят данные существующего поля
            // Если поля с таким именем еще нет, оно добавится в конец списка полей
            $mergeField = function($newField) use (&$model) {
                foreach($model["fields"] as $fieldIndex => $field) {
                    if($field["name"] == $newField["name"]) {
                        foreach($newField as $nk => $nv) {
                            $model["fields"][$fieldIndex][$nk] = $nv;
                        }
                        return;
                    }
                }
                $model["fields"][] = $newField;
            };
            
            // Добавляет в модель $model данные $newData
            $mergeData = function($newData) use (&$model,&$mergeField) {
            
                $mergedFields = array();
            
                if(is_array($newData)) {
                    if(array_key_exists("fields", $newData)) {
                        foreach($newData["fields"] as $fieldData) {
                             $mergedFields[] = $fieldData["name"];
                             $mergeField($fieldData);
                        }
                    }
                }
                
            };
            
            // Добавляем в модель данные поведений              
            $behaviours = \Infuso\Core\BehaviourMap::getBehavioursForMethod($class, "model");
            foreach($behaviours as $behaviour) {
                $mergeData($behaviour::model());
            }
            
            // Добавляем в модель данные из сценариев
            if($scenario) {
                foreach($model["fields"] as $index => $null) {
                    $model["fields"][$index]["editable"] = 0;
                }
                $mergeData($model["scenarios"][$scenario], true);            
            }
            
            unset($model["scenarios"]);
            
            $cache->set($cacheKey, $model);
        
        }
        return $model;
    }

    /**
     * Фабрика полей
     * Возвращает поле по его имени
     * @todo сделать кэширвоанеи работы
     **/
    public function fieldParams($name) {
		$model = $this->modelExtended($this->scenario());
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
        $model = $this->modelExtended($this->scenario());

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
    public final function data($key = null, $val = null) {

        // Если параметров 0 - возвращаем массив с данными
        if(func_num_args() == 0) { 
            $ret = array();
            foreach($this->fieldNames() as $name) {
                $ret[$name] = $this->data($name);
            }
            return $ret;
        }

        // Если параметров 1 - возвращаем значение поля
        if(func_num_args() == 1) {
            
            if(array_key_exists($key, $this->preparedData)) {
            
                return $this->preparedData[$key];
                
            } else {
            
                if(array_key_exists($key, $this->changedDataRaw)) {
                    $value = $this->changedDataRaw[$key];
                } elseif (array_key_exists($key, $this->initialDataRaw)) {
    				$value = $this->field($key)->prepareValue($this->initialDataRaw[$key]);
    			} else {
                    $value = $this->field($key)->defaultValue();
                };
                
                $this->preparedData[$key] = $value;
                return $value;
                            
            }
            
        }

        // Если два параметра - меняем значение
        elseif(func_num_args() == 2) {
            $field = $this->field($key);
            
            // Подготавливаем новое и старое значение, чтобы корректно сравнить их
            $preparedValue = $field->prepareValue($val);
            // Старое зрачение и так подготовлено
            $oldPreparedValue = $field->value();
            
			// Если старое и новое значения совпадают, ничего не делаем
            if($preparedValue != $oldPreparedValue) {
	            $this->changedDataRaw[$key] = $preparedValue;
                $this->preparedData[$key] = $preparedValue;
	            $this->handleModelDataChanged();
            }
            
            return $this;
        }
    }
    
    /**
     * Возвращает начальный данные модели
     * Данные прогоняются через prepareValue() полей
     **/
    public final function initialData() {
        $ret = array();
        foreach($this->fields() as $field) {
            $ret[$field->name()] = $field->prepareValue($this->initialDataRaw[$field->name()]);
        }
        return $ret;
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
     * Устанавливает исходные данные модели
     **/
    public final function setInitialData($data) {

        if($data === null) {
            $data = array();
        }

        if(!is_array($data)) {
            throw new \Exception("Model::setInitialData() first argument must be array, ".gettype($data)." given");
        }

        $this->changedDataRaw = array(); 
        $this->initialDataRaw = $data;
        $this->preparedData = array();
    }
    
    public function revertInitialData() {
        $this->changedDataRaw = array();
        $this->perparedData = array();
    }
    
    public final function isFieldChanged($key) {
        return array_key_exists($key, $this->changedDataRaw);
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
            $event = new ValidationEvent(array(
                "model" => $this,
                "field" => $field,
                "value" => $data[$field->name()],
                "data" => $data,
            ));
            $field->validate($event);
            if(!$event->isValid()) {
                return false;
            }
        } 
        
        $model = $this->modelExtended($this->scenario());
        if($callback = $model["validationCallback"]) {
            $event = new ValidationEvent(array(
                "model" => $this,
                "field" => null,
                "value" => null,
                "data" => $data,
                "callback" => $callback,
            ));
            call_user_func($callback, $event);
            if(!$event->isValid()) {
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
	 * заполняет данные модели из массива $data
	 * Данные предварительно валидируются в соответствии с активнм сценарием
	 * Будут заполнены только те поля, которые отмечены как редактируемые в сценарии
	 **/
	public function fill($data) {    
	
		if(!$this->validate($data)) {
            $errors = "";
            foreach($this->getValidationErrors() as $error) {
                $errors .= $error["name"].": ".$error["text"]." ";
            }
		    throw new \Exception("Model::fill() validation failed. " . $errors);
		}
		
        foreach($data as $name => $value) {
            $field = $this->fields($key);
            if($field->editable()) {
                $this->data($name, $value);
            }
        }
		
		return $this;
	
	}

}
