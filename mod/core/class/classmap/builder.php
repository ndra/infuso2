<?

namespace Infuso\Core\Classmap;

use infuso\core\file as file;
use infuso\core\mod as mod;

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
	 * Возвращает список классов модуля
	 * Сканирует все папки с классами, работает долго.
	 * Поэтому вызывается только при релинке для того чтобы построить карту классов
	 **/
	private static function classMap($secondScan) {

		$excludes = array();
		foreach(file::get(self::excludePath())->dir() as $file) {
		    $excludes[] = $file->basename();
		}

		$ret = array();
		
		$bundles = mod::service("bundle")->all();

		foreach($bundles as $bundle) {
		    foreach($bundle->classPath()->search() as $file)
		        if($file->ext()=="php") {

		            $descr = array(
						"f" => $file->path(),
						"p" => array(),
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
		        	
		        	if(!preg_match("/[a-zA-Z0-9\_\/]/",$class)) {
						app()->msg("Class $class have strange symbols in it's name.",1);
		        	}
		        	    
					if(array_key_exists($class,$ret) && !$secondScan) {
					    app()->msg("Duplicate file ".$file->path()." for class $class",1);
					}

		        	if($secondScan) {

		        	    // Предотвращаем фатальные ошибки при построении карты классов
		        	    // Если при инклуде файла произошла ошибка, то второй раз этот файл не подключится
		        	    // Пока не изменится его содержимое
					    $hash = md5($file->data());
					    if(in_array($hash,$excludes)) {
					        app()->msg("File ".$file->path()." disabled due fatal error on previous relink",1);
					        continue;
						}
						file::mkdir(self::excludePath(),1);
						file::get(self::excludePath()."/$hash.txt")->put($file->path());
						class_exists($class);
						file::get(self::excludePath()."/$hash.txt")->delete();

			        	// Отмечаем абстрактные классы
						$reflection = new \ReflectionClass($class);
						if($reflection->isAbstract() || $reflection->isInterface())
							$descr["a"] = 1;

			        	// Расчитываем родителей
			        	$parent = $class;
			        	while($parent) {
			        	    $parent = get_parent_class($parent);
							if($parent)
								$descr["p"][] = strtolower($parent);
			        	}
		        	}

					$ret[$class] = $descr;

				}
			}
		return $ret;
	}

	public function sortbehaviours($a,$b) {
		$a = new $a;
		$b = new $b;
		return $a->behaviourPriority() - $b->behaviourPriority();
	}

	/**
	 * Функция возвращает поведения по умолчанию ввиде массива
	 * Этот массив будет использован при построении карты классов
	 **/
	public static function defaultBehaviours() {

		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(mod::service("classmap")->classes("Infuso\Core\Behaviour") as $class) {
		    $obj = new $class;
		    if($for = $obj->addToClass()) {
		        $ret[$for][] = $class;
		    }
		}

		// Сортируем поведения
		foreach($ret as $key=>$val) {
		    usort($ret[$key],array(self,"sortBehaviours"));
		}

		return $ret;
	}

	/**
	 * Возвращает часть карты сайта, в которйо содержатся обработчики событий
	 **/
	public static function handlers() {
		$handlers = array();
		foreach(mod::service("classmap")->classes() as $class=>$fuck) {
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
		
		foreach($handlers as $key => $val) {
			usort($handlers[$key], function($a,$b) {
			    return $a["priority"] - $b["priority"];
			});
		}
		
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
		foreach(mod::service("classmap")->classes() as $class=>$fuck) {
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
	
	public function sortRoutes($a,$b) {
	    $a = new $a();
	    $b = new $b();
	    return $b->priority() - $a->priority();
	}
	
	public static function getRoutes() {

		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(mod::service("classmap")->classes("infuso\\core\\route") as $class) {
			$ret[] = $class;
		}
		
		// Сортируем поведения
	    usort($ret,array(self,"sortRoutes"));

		return $ret;
	}
	
	/**
	 * Вовзарает описание полей
	 **/
	public static function buildFields() {
	
		$ret = array();

		// Берем поведения по умолчанию (на основании mod_behaviour::addToClass)
		foreach(mod::service("classmap")->classes("Infuso\\Core\\Model\\Field") as $class) {
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
	
	/**
	 * Строит карту классов
	 **/
	public static function buildClassMap() {
	
	    if(self::$building) {
	        return array();
	    }
	
	    self::$building = true;
	
		$map = array();

		// расчитываем карту классов в два шага
		// На первом - просто собираем пути к файлам
		// На втором - родителей
		$map["map"] = self::classMap(false);
			    
		mod::service("classmap")->setClassMap($map);
		$map["map"] = self::classMap(true);
		mod::service("classmap")->setClassMap($map);
		
		$map["behaviours"] = self::defaultBehaviours();
		$map["handlers"] = self::handlers();
		$map["routes"] = self::getRoutes();
		$map["services"] = self::services();
		$map["fields"] = self::buildFields();

		// Сохраняем карту классов в памяти, чтобы использовать ее уже в этом запуске скрипта
		mod::service("classmap")->storeClassMap($map);

		app()->msg("Карта классов построена");
		
		self::$building = false;
	}

}
