<?

namespace Infuso\Core;

/**
 * Класс, реализующий карту поведений
 **/
class BehaviourMap {

	/**
	 * Возвращает массив поведений, прикрепленных к данному классу
	 * Элемент массива - строка с именем класса поведения
	 **/
	public static function getBehaviours($class, $addBehaviours, $behaviourHash) {
    
        $class = strtolower($class);
        
        return service("cache")->get("system/behaviour-list/".$class."/".$behaviourHash, function() use (&$class, &$addBehaviours, &$behaviourHash) {
	
            $behaviours = array();
    
            // Добавлеям поведения по умолчанию
            foreach($class::defaultBehaviours() as $b) {
                $behaviours[] = $b;
    		}
    
    		// Добавляем поведения из карты классов
            $bb = service("classmap")->classmap("behaviours");
            $bb = $bb[$class];
            if($bb) {
                foreach($bb as $b) {
                    $behaviours[] = $b;
    			}
    		}
    		
            // Добавим поведения, добавленные вручную
    		foreach($addBehaviours as $b) {
    		    $behaviours[] = $b;
    		}
    		
            // На всякий случай уберем дубликаты
    		$behaviours = array_unique($behaviours);
    
            // Отсортируем по приоритету
    		usort($behaviours, function($a, $b) {
    		    return $a::behaviourPriority() - $b::behaviourPriority();
    		});
    		
    		return $behaviours;
        });
	
	}

	/**
	 * Возвращает карту поведений для класса $class
	 * Кэширует результат
	 **/
	private static function getMap($class, $addBehaviours = array(), $behavioursHash = "") {
		
		Profiler::beginOperation("core", "behaviour map", $class);
	
	    $key = "system/behaviours-map-".$class."-".$behavioursHash;
	    $data = service("cache")->get($key);
	    
	    Profiler::endOperation();

	    if($data === null) {
	        $data = self::getMapNocache($class, $addBehaviours, $behavioursHash);
	        service("cache")->set($key, $data);
	    }
	    
	    return $data;
	
	}

	/**
	 * Возвращает карту поведений для класса $class
	 * Результат не кэшируется
	 **/
    private static function getMapNocache($class, $addBehaviours, $behavioursHash) {
    
        $behaviours = self::getBehaviours($class, $addBehaviours, $behavioursHash);
    
        $ret = array();
        foreach($behaviours as $b) {
            $r = new \ReflectionClass($b);
            foreach($r->getMethods() as $method) {
                if(strtolower($method->getDeclaringClass()->getName()) == "infuso\\core\\behaviour") {
					break;
                }
                $ret[strtolower($method->getName())][] = $r->getName();
            }
        }
        
        return $ret;
    }
    
    public static function routeMethod($class, $method, $addBehaviours, $behavioursHash) {
        $map = self::getMap($class, $addBehaviours, $behavioursHash);
        $behaviours = $map[$method];
        if(!$behaviours) {
            return;
        }
        return end($behaviours);
    }
    
    public function getBehavioursForMethod($class, $method, $addBehaviours = array(), $behavioursHash = "") {
        $map = self::getMap($class, $addBehaviours, $behavioursHash);
        $behaviours = $map[$method];
        if(!$behaviours) {
            $behaviours = array();
        }
        return $behaviours;
    }
    
}
