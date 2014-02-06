<?

namespace infuso\ActiveRecord;
use \infuso\core\mod;
use \infuso\core\file;

/**
 * Класс с набором статических методов-утилит для ActiveRecord
 **/
class util {

    /**
     * Буфер для фабрики таблиц forReclexClass()
     **/
    private static $bufferReflex = array();

	/**
	 * Возврашает имя класса reflex для данного класса
	 * Использовалось раньше для переопределения классов
	 * Можно было сделать так чтобы reflex::get("user") возвращало бы объект другого класса
	 * С появлением поведений необходимоть с это отпала
	 * Метод вернет reflex_none при обращении к классу, которого не существует
	 **/
	public static function getItemClass($class) {

	    if(!mod::app()->service("classmap")->testClass($class,"reflex") && !mod::app()->service("classmap")->testClass($class,"infuso\\ActiveRecord\Record")) {
			return "reflex_none";
		}

		return $class;
	}

    /*public function factoryTableForReflexClass($class) {

        if(!self::$bufferReflex[$class]) {

            $iClass = util::getItemClass($class);

            $obj = new $iClass(0);
            $ret = $obj->reflex_table();

            // Если не указаны таблицы, используем имя класса в качестве таблицы.
            if($ret=="@")
                $ret = $class;

            if(is_string($ret)) {
                $table = table::factoryByName($ret);
            } elseif (is_array($ret)) {
                $table = new self(\infuso\util\util::id(),$ret);
            } else {
                $table = new self(null);
            }

            // Добавляем к таблице поля из поведений
            foreach($obj->callBehaviours("fields") as $field) {
                $table->addField($field);
            }

            // Добавляем к таблице индексы из поведений
            foreach($obj->callBehaviours("indexes") as $index) {
                $table->addIndex($index);
            }

            self::$bufferReflex[$class] = $table;

        }

        return self::$bufferReflex[$class];

    }*/
	
}
