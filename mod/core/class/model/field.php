<?

namespace Infuso\Core\Model;
use infuso\util\util;
use Infuso\Core;

abstract class Field extends Core\Component {

	const HIDDEN = 0;
	const EDITABLE = 1;
	const READ_ONLY = 2;

	/**
	 * Здесь содержится значение поля
	 **/

    protected $model = null;

    protected $exists = true;
    
    /**
     * Значение для случая, когда поле используется без модели
     **/
    protected $value;

    /**
     * Конструктор поля
     **/
    public function __construct($params = array()) {
		if(is_array($params)) {
        	$this->params($params);
        }
    }
    
    /**
     * Преобразует алиас в класс поля
     **/
    public static function aliasToClassName($alias) {
    
        if(!is_string($alias)) {
			Throw new \Exception("Bad field alias");
        }

        if(service("classmap")->testClass($alias,"\\Infuso\\Core\\Model\\Field")) {
            return $alias;
        }
        
        $aliases = service("classmap")->classmap("fields");
        if(!$class = $aliases[$alias]) {
            Throw new \Exception("Field alias {$alias} not found");
        }
        
        return $class;
        
    }
    
    /**
     * Фабрика-конструктор полей
     * Если передана строка, то она трактуется как имя класса или тип поля
     * Если передан массив, он используется как конфигурация поля
     **/
    public static function get($conf) {
    
		if (is_string($conf)) {

			$class = self::aliasToClassName($conf);
            $conf = array(
                "editable" => 1,
            );

        } elseif(is_array($conf)) {
            $class = self::aliasToClassName($conf["type"]);
        } else {
            throw new \Exception("Bad argument for Field::get() (".gettype($conf).")");
        }

        return new $class($conf);
    }

    /**
     * Создает несуществующее поле
     * Используется в mod_fieldset::field() если запрашиваемого поля не существует
     **/
    public function getNonExistent() {
        $field = new Textfield;
        $field->exists = false;
        return $field;
    }

    /**
     * Устанавливает объект модели, связанный с данным полем
     **/
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    /**
     * Возвращает модель, с которой связано это поле
     **/
    public function model() {
        return $this->model;
    }

    /**
     * @return true/false существует ли поле
     **/
    public final function exists() {
        return $this->exists;
    }

    /**
     * @return Возвращает массив полей - по одному каждого типа
     **/
    public static function all() {
        $ret = array();
        self::loadDescription();
        foreach(array_unique(self::$descr) as $typeID => $className) {
            $ret[] = self::get(array("type" => $typeID));
        }
        return $ret;
    }

    /**
     * @return Должна вернуть уникальный тип поля
     **/
    public abstract function typeID();

    /**
     * @return Возвращает алиас типа поля
     * Алиас используется при создании поля, чтобы не запоминвать громоздкий ID или имя класса
     **/
    public function typeAlias() {
        $class = get_called_class();
        if(preg_match("/^infuso\\\\core\\\\model\\\\(.*)/i",$class,$matches)) {
            return strtolower($matches[1]);
		}
    }

    /**
     * @return Должна вернуть имя типа поля
     **/
    public abstract function typeName();
    
    public function dataWrappers() {
        return array(
            "name" => "mixed",
            "label" => "mixed",
            "help" => "mixed",
            "group" => "mixed",
		);
    }

    /**
     * Возвращает / изменяет значение этого поля
     **/
    public final function value($value = null) {

        // Если функция вызвана без параметров, возвращаем значение поля
        // Если значение было изменено, возвращаем измененое значение
        if(func_num_args() == 0) {
            if($this->model()) {
                return $this->model()->data($this->name());
            } else {
                return $this->value;
            }
        }

        if(func_num_args() == 1) {        
            if($this->model()) {
                return $this->model()->data($this->name(), $value);
            } else {
                $this->value = $value;
            }
        }
    }

    /**
     * @return Возвращает true, если поле было изменено
     **/
    public final function changed() {
		return $this->model()->isFieldChanged($this->name());
    }

    /**
     * Возвращает значение поля по умолчанию
     * Это значение будет использоваться до явного указания значения поля методом value()
     **/
    public function defaultValue() {
        return $this->prepareValue($this->param("default"));
    }

    /**
     * Возвращает значение поля до изменения
     **/
    public function initialValue() {
        $initialData = $this->model()->initialData();
        return $initialData[$this->name()];
    }

    /**
     * @return Возвращает обработанное значение поля. Тип возвращаемого значения
     * и способ обработки зависит от типа поля
     **/
    public function pvalue() {
        return $this->value();
    }

    /**
     * @return Возвращает человекопонятное значение поля (строку)
     **/
    public function rvalue() {
        return util::str($this->value())->esc()->ellipsis(1000)."";
    }

    /**
     * Подготовака поля для сохранения в модель
     * Поведение зависит от типа поля
     * Например, для числовых полей строка конвертируется в число, и выполняется
     * преобразование "," => "."
     * Для полей типа файл - файл преобразуется в стрку и т.п.
     **/
    public function prepareValue($val) {
        return $val;
    }
    
    public function mysqlValue() {
        return service("db")->quote($this->value());
    }

    public function mysqlType() {
    }

    public function mysqlAutoincrement() {
        return false;
    }

    public function mysqlNull() {
    }

    public function dbIndex() {
        return array(
            "type" => "index",
            "name" => "+".$this->name(),
            "fields" => $this->name(),
		);
    }

    /**
     * Возвращает режим редактирования:
     * 0 - поле скрыто
     * 1 - Редактируемое
     * 2 - Только чтение
     **/
    public final function editMode() {
    
        if($this->editable()) {
            return 1;
        }
        
        if($this->readonly()) {
            return 2;
		}
		
        return 0;
    }

    /**
     * @return Видимо ли данное поле?
     **/
    public final function visible() {
        return !!$this->param("editable");
    }

    /**
     * @return Можно ли редактировать данное поле
     * @todo убрать жесткий запрет на редактирвоание поля id
     **/
    public final function editable() {
        if($this->name()=="id") {
            return false;
		}
        return $this->param("editable") == self::EDITABLE;
    }

    /**
     * @return Поле только для чтения?
     **/
    public final function readonly() {
        return $this->param("editable") == self::READ_ONLY;
    }
    
    public function validate($val, $data) {

        $validateIf = $this->param("validateIf");
        if($validateIf && !$data[$validateIf]){
            return true;
        }

        $min = $this->param("min");
        if($min > 0 && mb_strlen($val) < $min) {
            return false;
        }
        
        $max = $this->param("max");
        if($max > 0 && mb_strlen($val) > $max) {
            return false;
        }

        $eq = $this->param("eq");
        if($eq && $eq !=  $val){
            return false;
        }

        $checkEmail = $this->param("email");
        if($checkEmail && !preg_match("/^[\S]+@[\S]+\.[\S]+$/",$val)){
            return false;
        }

        /*$callback = $this->param("callback");
        if($callback) {
            $c = explode("::", $callback);
            if(!call_user_func($c, $val, $data, $this->model()) {
                return false;
            }
        } */

        return true;
    }
    
    public function validationErrorText() {
        $error = trim($this->param("error"));
        if(!$error) {
            $error = "Поле заполнено неверно";
        }
        return $error;
    }

}
