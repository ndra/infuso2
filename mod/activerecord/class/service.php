<?

namespace infuso\ActiveRecord;
use \Infuso\Core;


/**
 * Служба для управления объектами ActiveRecord
 **/
class Service extends Core\Service {

    private static $buffer = array();
    
    private static $changedItems = array();

	public function defaultService() {
	    return "ar";
	}
	
	private static $serviceInstance;

	/**
	 * @todo этот метод реализован в Core\Service, использовать его
	 **/
    public static function serviceFactory() {

        if(!self::$serviceInstance) {
			self::$serviceInstance = new self;
		}
        return self::$serviceInstance;

    }
	
	public static function getItemClass($class) {

	    if(!is_subclass_of($class, "infuso\\activeRecord\\record")) {
			return "reflex_none";
		}

		return $class;
	}
	
	/**
	 * @todo ен складывает в буффер объекты после загрузки, пофиксить
	 **/
	public function get($class, $id, $data=array()) {
	
	    if(!is_numeric($id) && $id !== null && $id !== false && $id !== "") {
	        throw new \Exception("active record id must be integer. Given ".var_export($id, 1));
	    }
	
        // Определяем класс элементов / последовательности
        $class = self::getItemClass($class);

        // Если id <= 0, возвращаем несуществующий объект без запроса в базу
        if($id <= 0) {
            $ret = new $class();
            $ret->setRecordStatus(Record::STATUS_NON_EXISTENT);
            return $ret;
        }

        $item = self::$buffer[$class][$id];
        if(!$item) {
            
            if($data) {
                $item = new $class($id);
                $item->setInitialData($data);
				$item->setRecordStatus(Record::STATUS_SYNC);                
            } else {
                $item = self::collection($class)->eq("id",$id)->one();
            }
            
            $this->storeToBuffer($item);
        }
        
        return $item;
	
	}
	
	/**
	 * Сохраняет переданную запись в буффер
	 **/	  	
	public function storeToBuffer($record) {
		$class = get_class($record);
		$id = $record->id();
		self::$buffer[$class][$id] = $record;
	}
	
	/**
	 * Возвращает коллекцию элементов класса $class
	 **/
	public function collection($class) {
		return Collection::get($class);
	}
	
	/**
	 * Создает новую запись в базе
	 **/
	public function create($class, $data = array(), $keepID = false) {

		if(!is_string($class)) {
            throw new \Exception ("reflex::create() first argument must be string, have ".gettype($class));
        }

        $class = self::getItemClass($class);
        $item = new $class();
        $item->setInitialData($data);
        $item->createThis($keepID);
        return $item;
	
	}
	
	/**
	 * Создает виртуальный обект
	 **/
	public function virtual($class, $data=array()) {

		if(!is_string($class)) {
            throw new \Exception ("reflex::create() first argument must be string, have ".gettype($class));
        }

        $class = self::getItemClass($class);
        $item = new $class();
        $item->setInitialData($data);
        $item->setRecordStatus(Record::STATUS_DETACHED);
        return $item;
	
	}	
	
	/**
	 * Регистрирует изменения в объекте класса $class с ключем $id
	 **/
	public function registerChanges($class,$id) {
	    self::$changedItems[$class.":".$id] = true;
	}
	
	/**
	 * Удаляет пометку об изменениях в объекте класса $class с ключем $id
	 **/
	public function unregisterChanges($class,$id) {
	    unset(self::$changedItems[$class.":".$id]);
	}
	
	/**
	 * Сохраняет все измененные объекты
	 **/
	public function storeAll() {

        Core\Profiler::addMilestone("reflex before store");

        $items = array_keys(self::$changedItems);

        while(sizeof($items)) {

            self::$changedItems = array();

            foreach($items as $key) {
                list($class,$id) = explode(":",$key);
                $item = self::get($class,$id);
                $item->store();
            }

            $items = array_keys(self::$changedItems);
            $n++;

            // Защита от рекурсии
            // При сохранении объекта может дернуться триггер, который опять вызовет сохранение объекта
            if($n > 100) {
				throw new Exception("reflex_storeAll() - recursion");
			}

        }

        Core\Profiler::addMilestone("reflex stored");
	
	}
	
    /**
     * Очищает буффер
     * @todo сделать чтобы записям в буффере ставился статус detached
     **/
	public function clearBuffer() {
        $this->storeAll();
        self::$buffer = array();
	}
	
}
