<?

namespace Infuso\Core\Classmap;

use infuso\core\file as file;
use infuso\core\mod as mod;  
use \Infuso\Core;

class Builder {

	private static $building = false;

	public function excludePath() {
	    return mod::app()->varPath()."/exclude/";
	}

	/**
	 * Парсит файл и возвращает массив с информацией о классе
	 * array(
	 *   "type" => "class" / "interface",
	 *   "class" => "className",
	 *   "abstract" => true / false
	 * )
	 **/
	public function getFileInfo($path) {
	
	    $ret = array(
	        "abstract" => false,
		);
	
	    $str = file::get($path)->data();
	    $tokens = @token_get_all($str);
	    
	    $catchClassName = false;
	    foreach($tokens as $token) {
	    
	        switch($token[0]) {
	        
	            default:
	                $catchClassName = false;
	                $catchNamespace = false;
					break;
	        
	            case T_CLASS:
	                $catchClassName = true;
	                $catchNamespace = false;
	                $type = "class";
	                break;
	                
				case T_INTERFACE:
	                $catchClassName = true;
	                $type = "interface";
	                break;
	                
				case T_ABSTRACT:
				    $ret["abstract"] = true;
				    break;
				    
				case T_NAMESPACE:
				    $catchNamespace = true;
				    break;
	                
				// Игнорируем пробелы
				case T_WHITESPACE;
				    break;
				    
				case T_NS_SEPARATOR:
				    if($catchNamespace) {
				    	$ret["namespace"].= "\\";
				    }
				    break;
	                
				case T_STRING:
				
				    if($catchNamespace) {
						$ret["namespace"].= $token[1];
				    }
				    
				    if($catchClassName) {
						$ret["type"] = $type;
						$ret["class"] = $token[1];
						$ret["namespace"] = trim($ret["namespace"],"\\");
						return $ret;
				    }
				    break;
	        }
	    }
	}
    
    /**
     * Шаг 1: Возвращает массив с классами
     **/
    private static function step1() {
    
        // Собираем эксклуды
		$excludes = array();
		foreach(file::get(self::excludePath())->dir() as $file) {
		    $excludes[] = $file->basename();
		}

		$map = array(
            "classes" => array(),
        );
		
		$bundles = service("bundle")->all();

		foreach($bundles as $bundle) {
		    foreach($bundle->classPath()->search() as $file) {
		        if($file->ext() == "php") {

		            $descr = array(
						"f" => $file->path(),
					);

					$info = self::getFileInfo($file->path());
					$class = $info["class"];
					
					if($info["namespace"]) {
					    $class = $info["namespace"]."\\".$class;
					}

		        	if(!$class) {
		        	    continue;
		        	}
		        	
		        	$class = strtolower($class);
		        	
		        	if(!preg_match("/[a-zA-Z0-9\_\/]/", $class)) {
						app()->msg("Class $class have strange symbols in it's name.",1);
		        	}
		        	    
					if(array_key_exists($class, $map["classes"])) {
					    app()->msg("Duplicate file ".$file->path()." for class $class",1);
					}
                    
	        	    // Предотвращаем фатальные ошибки при построении карты классов
	        	    // Если при инклуде файла произошла ошибка, то второй раз этот файл не подключится
	        	    // Пока не изменится его содержимое
				    $hash = md5($file->data());
				    if(in_array($hash, $excludes)) {
				        app()->msg("File ".$file->path()." disabled due fatal error on previous relink",1);
				        continue;
					}
                    
                    $map["classes"][$class] = $descr;
                }
            }
        }
        
        return $map;
    
    }
    
    /**
     * Шаг 2: Учет информации о классе
     **/
    private static function step2() {
        $map = self::step1();
        service("classmap")->setClassMap($map);
        foreach($map["classes"] as $class => &$descr) {
        
            $file = Core\File::get($descr["f"]);
            $hash = md5($file->data());
			file::mkdir(self::excludePath(), 1);
			file::get(self::excludePath()."/$hash.txt")->put($file->path());
			class_exists($class);
			file::get(self::excludePath()."/$hash.txt")->delete();

        	// Отмечаем абстрактные классы
			$reflection = new \ReflectionClass($class);
			if($reflection->isAbstract() || $reflection->isInterface()) {
				$descr["a"] = 1;
            }

        	// Расчитываем родителей
        	$parent = $class;
        	while($parent) {
        	    $parent = get_parent_class($parent);
				if($parent) {
					$descr["p"][] = strtolower($parent);
                }
        	}        
        }
        
        return $map;
    }
    
    private static function step3() {
    
        $map = self::step2();   
        service("classmap")->setClassMap($map); 
		$map["behaviours"] = self::defaultBehaviours();
		$map["handlers"] = self::handlers();
		$map["routes"] = self::getRoutes();
		$map["services"] = self::services();
		$map["fields"] = self::buildFields();
		$map["controllers"] = self::buildControllers();

		// Сохраняем карту классов в памяти, чтобы использовать ее уже в этом запуске скрипта
        service("classmap")->setClassMap($map);
		service("classmap")->store();

		app()->msg("Карта классов построена");
    
    }    

	/**
	 * Функция возвращает поведения по умолчанию ввиде массива
	 * Этот массив будет использован при построении карты классов
	 **/
	public static function defaultBehaviours() {

		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(service("classmap")->classes("Infuso\Core\Behaviour") as $class) { 
		    if($for = $class::addToClass()) {
                $for = trim($for,"\\");
                $for = strtolower($for);
		        $ret[$for][] = $class;
		    }
		}

		return $ret;
	}

	/**
	 * Возвращает часть карты сайта, в которой содержатся обработчики событий
	 **/
	public static function handlers() {
		$handlers = array();
		foreach(service("classmap")->classes() as $class) {
			$r = new \ReflectionClass($class);
			if($r->implementsInterface("Infuso\\Core\\Handler")) {
			
				$inspector = new \Infuso\Core\Inspector($class);
				foreach($inspector->annotations() as $method => $annotation) {
				    $event = $annotation["handler"];
				    $priority = (int)$annotation["handlerPriority"];
				    if($event) {
				        $handlers[$event][] = array(
							"handler" => $class."::".$method,
							"priority" => $priority,
						);
				    }
				}
				
			}
		}
		
        // Сортируем обработчики
		foreach($handlers as $key => $val) {
			usort($handlers[$key], function($a,$b) {
			    return $a["priority"] - $b["priority"];
			});
		}
		
        // Приводим массив к тому виду, который будет в карте классов
        // Удаляем лишнее
		foreach($handlers as $event => $list) {
			foreach($list as $key => $val) {
			    $handlers[$event][$key] = $val["handler"];
			}
		}
		
		return $handlers;
	}
	
	/**
	 * Собирает описания служб
	 **/
	public static function services() {
		$services = array();
		foreach(service("classmap")->classes() as $class) {
			$r = new \ReflectionClass($class);
			if($r->isSubclassOf("mod_service") && !$r->isAbstract()) {
			    $item = new $class;
			    if($defaultService = $item->defaultService()) {
		        	$services[$defaultService] = $class;
		        }
			}
		}
		return $services;
	}
	
	public static function getRoutes() {

		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(service("classmap")->classes("infuso\\core\\route") as $class) {
			$ret[] = $class;
		}
		
		// Сортируем поведения
	    usort($ret, function($a,$b) {
            $a = new $a();
            $b = new $b();
            return $b->priority() - $a->priority();
        });

		return $ret;
	}
	
	/**
	 * Вовзарает описание полей
	 **/
	public static function buildFields() {
	
		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(service("classmap")->classes("Infuso\\Core\\Model\\Field") as $class) {
			$ret[$class::typeId()] = $class;
			if($alias = $class::typeAlias()) {
			    if(!is_array($alias)) {
			        $alias = array($alias);
			    }
			    foreach($alias as $a) {
			        $ret[$a] = $class;
			    }
			}
		}

		return $ret;
	}
	
	public function buildControllers() {
		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(service("classmap")->classes("Infuso\\Core\\Controller") as $class) {
			$ret[strtolower($class::controller())] = $class;
		}

		return $ret;
	}
	
	/**
	 * Строит карту классов
	 **/
	public static function buildClassMap() {
        self::step3();
	}

}
