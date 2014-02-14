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

    public static function serviceFactory() {

        if(!self::$serviceInstance) {
			self::$serviceInstance = new self;
		}
        return self::$serviceInstance;

    }
	
	public static function getItemClass($class) {

	    if(!Core\Mod::app()->service("classmap")->testClass($class,"reflex") && !Core\Mod::app()->service("classmap")->testClass($class,"infuso\\ActiveRecord\Record")) {
			return "reflex_none";
		}

		return $class;
	}
	
	public function get($class,$id,$data=array()) {
	
        // Определяем класс элементов / последовательности
        $class = self::getItemClass($class);

        // Если id <= 0, возвращаем несуществующий объект без запроса в базу
        if($id <= 0) {
            $ret = new $class(0);
            return $ret;
        }

        $item = self::$buffer[$class][$id];
        if(!$item) {
            
            if($data) {
                $item = new $class($id);
                $item->setInitialData($data);
				$item->setRecordStatus(Record::STATUS_SAVED);
                self::$buffer[$class][$id] = $item;
                
            } else {
                $item = self::collection($class)->eq("id",$id)->one();
            }
        }
        
        return $item;
	
	}
	
	public function collection($class) {
		return Collection::get($class);
	}
	
	public function virtual($class,$data=array()) {
	
        $class = self::getItemClass($class);
        $item = new $class($data["id"]);
        $item->setRecordStatus(Record::STATUS_VIRTUAL);
        $item->setInitialData($data);
        return $item;
	
	}
	
	/**
	 * Создает новую запись в базе
	 **/
	public function create($class, $data=array(), $keepID = false) {

		if(!is_string($class)) {
            throw new Exception ("reflex::create() first argument must be string, have ".gettype($class));
        }

        $class = self::getItemClass($class);
        $item = new $class();
        $item->setRecordStatus(Record::STATUS_NEW);
        $item->setInitialData($data);
        $item->createThis($keepID);
        return $item;
	
	}
	
	public function registerChanges($class,$id) {
	    self::$changedItems[$class.":".$id] = true;
	}
	
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

            if($n>100) {
				throw new Exception("reflex_storeAll() - recursion");
			}

        }

        Core\Profiler::addMilestone("reflex stored");
	
	}
	
	/**
	 * Освобождает буффер объектов
	 * несохраненные объекты сохраняются автоматически
	 **/
	public function freeAll() {
		foreach(self::$buffer as $class) {
            foreach($class as $item) {
                $item->free();
            }
        }
        self::$buffer = array();
        self::$changedItems = array();
	}
	
	public function clearBuffer() {
	}
	
}
