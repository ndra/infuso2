<?

namespace Infuso\Core\Model;
use infuso\util\util;
use Infuso\Core;

abstract class Field extends Core\Component {

	/**
	 * Здесь содержится значение поля
	 **/
    private $value = null;
    
    private $changedValue = null;
    
    protected $model = null;

    protected $exists = true;

	/**
	 * Здесь будут сложены описания типов полей
	 **/
    private static $descr = array();
    
    /**
     * Пометка о том что поле изменилось
     **/
    private $changed = false;
    
    /**
     * Конструктор поля
     **/
    public function __construct($params = array()) {

        if(!$conf["id"]) {
            $conf["id"] = util::id();
        }

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

        if(\mod::service("classmap")->testClass($alias,"\\Infuso\\Core\\Model\\Field")) {
            return $alias;
        }
        
        $aliases = \mod::service("classmap")->classmap("fields");
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
            throw new \Exception("Bad argument for Field::get()");
        }

        return new $class($conf);
    }

    /**
     * Создает несуществующее поле
     * Используется в mod_fieldset::field() если запрашиваемого поля не существует
     **/
    public function getNonExistent() {
        $field = self::get(null);
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
     * Возвращает / устанавливает начальное значение поля
     **/
    public final function initialValue($val=null) {

        if(func_num_args()==0) {
            return $this->value;
        }
        
        if(func_num_args()==1) {
            $this->value = $this->prepareValue($val);
        }
    }

    /**
     * Возвращает / изменяет значение этого поля
     **/
    public final function value($value=null) {

        // Если функция вызвана без параметров, возвращаем значение поля
        // Если значение было изменено, возвращаем измененое значение
        if(func_num_args()==0) {
            return $this->model()->data($this->name());

        }

        if(func_num_args()==1) {

            $this->changedValue = $this->prepareValue($value);
            $this->changed = true;

            // Вызываем триггер
            // Он будет определен в поведении
            $this->afterFieldChange();

            return $this;
        }
    }

    /**
     * Триггер, вызывающийся при изменении поля
     **/
    public function _afterFieldChange() {
	}

    /**
     * Откатывает изменения значения поля
     **/
    public final function revert() {
        $this->changed = false;
    }
    
    public function applyChanges() {
        $this->changed = false;
        $this->value = $this->changedValue;
    }

    /**
     * @return Возвращает true, если поле было изменено
     **/
    public final function changed() {

        if($this->name()=="id") {
            return false;
        }

        if(!$this->changed) {
            return false;
        }
            
        return $this->prepareValue($this->value) !== $this->prepareValue($this->changedValue);
    }

    /**
     * Возвращает значение поля по умолчанию
     * Это значение будет использоваться до явного указания значения поля методом value()
     **/
    public function defaultValue() {
        return $this->prepareValue($this->param("default"));
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
        return mod::service("db")->quote($this->value());
    }

    /**
     * Возвращает id поля
     * id поля уникально среди всех полей, в отличие от name
     **/
    public final function id() {
        return $this->param("id");
    }

    /**
     * Возвращает описание поля (для редактора таблиц)
     **/
    public function descr() {
        return "Описание поля";
    }

    /**
     * Дополнительные параметры конфигурации
     **/
    public function extraConf() {
        return array();
    }

    /**
     * Возвращает ключи дополнительных параметров конфигурации
     **/
    public function extraConfKeys() {
        $ret = array();
        foreach($this->extraConf() as $conf) {
            $ret[] = $conf["name"];
        }
        return $ret;
    }

    public function mysqlType() {
    }

    public function mysqlAutoincrement() {
        return false;
    }

    public function mysqlNull() {
    }

    public function mysqlIndexFields() {
        return $this->name();
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
        return $this->param("editable")==1;
    }

    /**
     * @return Поле только для чтения?
     **/
    public final function readonly() {
        return $this->param("editable")==2;
    }

    /**
     * Делает поле видимым
     **/
    public function show() {
        $this->param("editable",1);
        return $this;
    }

    /**
     * Скрывает поле
     **/
    public function hide() {
        $this->param("editable",0);
        return $this;
    }

    /**
     * Делает поле «Только для чтения»
     **/
    public function disable() {
        $this->param("editable",2);
        return $this;
    }

}
