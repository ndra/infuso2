<?

namespace Infuso\Cms\Search;
use \Infuso\Core;

/**
 * Стандартная тема модуля search
 **/
class Handler implements Core\Handler {

    private static $classes;
    
     /**
     * Расписание выполенения задачи индексатора  
	 * если не задано, то каждый день в полночь
     **/ 
    public static function indexTiming() {
        $timing = service("conf")->get("components", "infuso\\cms\\search\\handler", "timing");
        
        if(!$timing) {
            $timing = "0 0 * * *";    
        }
        
        return $timing;
    }
    
     /**
     * Получаем предельное кол-во итераций за шаг   
	 * если не задано, ставим 20
     **/ 
    public static function indexSpeedMode() {
        $speed = service("conf")->get("components", "infuso\\cms\\search\\handler", "speed");
        
        if(!$speed) {
            $speed = 20;    
        }
        
        return $speed;
    }

    /**
     * @handler = infuso/deploy
     * Находит классы для поиска и записывает их массив в /var/record-classes.php     
     **/         
    public function collectClasses() {
    
        $searchClasses = array();
        foreach(service("classmap")->classes("infuso\\activerecord\\record") as $class) {
        
            $implements = class_implements($class);
            $implements = array_map(function($item) {
                return strtolower($item);
            }, $implements);
            
            if(in_array("infuso\\cms\\search\\searchable", $implements)) {
                $searchClasses[] = $class;
            }
        }
        
        Core\File::get(app()->varPath()."/search-classes.php")->put("<? return ".var_export($searchClasses, 1).";");
        
    }   
    
    public function classes() {
        if(!self::$classes) {
            self::$classes = Core\File::get(app()->varPath()."/search-classes.php")->inc();
        }
        return self::$classes;
    }
    
    /**
     * @handler = infuso/deploy
     **/         
    public function createCreator() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "createTask",
            "crontab" => self::indexTiming(), 
        ));
    }
    
    public static function createTask() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "indexStep",
        ));
    }
    
    
     /**
     * Прогоняем индексатор пока задача не будет выполнена 
     **/ 
    public static function indexStep($params, $task) {
        
        for ($step=0; $step<self::indexSpeedMode(); $step++){
            
            if($task->data("completed")){
                break;    
            }
            
            self::index($params, $task);          
        }
    }
    
    
    /**
     * Итерация поиска
     **/
    public static function index($params, $task) {
    
        $classes = self::classes();
        $classId = $task->pdata("internalParams")["classId"] ?: 0;
        $class = $classes[$classId];
        $fromId = $task->data("iterator"); 
        
        if(!$class) {
            $task->data("completed", true);
            service("search")->cleanup($task->id());
            return;
        }
        
        $item = service("ar")
            ->collection($class)
            ->asc("id")
            ->gt("id", $fromId)
            ->one();
            
        if($item->exists()) {        
            $task->data("iterator", $item->id());
            service("search")->indexRecord($item, $task->id());
            return;
        } else {
            $classId ++;
            $params = $task->pdata("internalParams");
            $params["classId"] = $classId;
            $task->data("internalParams", $params);
            $task->data("iterator", 0);
            return;
        }
    }

}
