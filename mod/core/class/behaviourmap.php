<?

namespace Infuso\Core;

/**
 * Класс, реализующий карту поведений
 **/
class BehaviourMap {

	/**
	 * Возвращает список поведений, прикрепленных к данному классу
	 **/
	public function getList($class,$addBehaviours) {
    
        $class = strtolower($class);
	
        $behaviours = array();

        // Добавлеям поведения по умолчанию
        foreach($class::defaultBehaviours() as $b) {
            $behaviours[] = $b;
		}

		// Добавляем поведения из карты классов
        $bb = mod::service("classmap")->classmap("behaviours");
        $bb = $bb[$class];
        if($bb) {
            foreach($bb as $b) {
                $behaviours[] = $b;
			}
		}
		
		foreach($addBehaviours as $b) {
		    $behaviours[] = $b;
		}
		
		$behaviours = array_unique($behaviours);

		usort($behaviours, function($a,$b) {
		    return $a::behaviourPriority() - $b::behaviourPriority();
		});
		
		return $behaviours;
	
	}

	/**
	 * Возвращает карту поведений для класса $class
	 * Кэширует результат
	 **/
	private function getMap($class,$addBehaviours,$behavioursHash) {
		
		Profiler::beginOperation("core","behaviour map",$class);
	
	    $key = "system/behaviours-map-".$class."-".$behavioursHash;
	    $data = Mod::service("cache")->get($key);
	    
	    Profiler::endOperation();

	    if($data === null) {
	        $data = self::getMapNocache($class,$addBehaviours);
	        Mod::service("cache")->set($key,$data);
	    }
	    
	    return $data;
	
	}

	/**
	 * Возвращает карту поведений для класса $class
	 * Результат не кэшируется
	 **/
    private static function getMapNocache($class,$addBehaviours) {
    
        $behaviours = self::getList($class,$addBehaviours);
    
        $ret = array();
        foreach($behaviours as $b) {
            $r = new \ReflectionClass($b);
            foreach($r->getMethods() as $method) {
                if($method->getDeclaringClass()->getName() == "Infuso\\Core\\Behaviour") {
					break;
                }
                $ret[$method->getName()][] = $r->getName();
            }
        }
        
        return $ret;
    }
    
    public static function routeMethod($class,$method,$addBehaviours,$behavioursHash) {
        $map = self::getMap($class,$addBehaviours,$behavioursHash);
        $behaviours = $map[$method];
        if(!$behaviours) {
            return;
        }
        return end($behaviours);
    }
    
    public function getBehavioursForMethod($class,$method,$addBehaviours,$behavioursHash) {
        $map = self::getMap($class,$addBehaviours,$behavioursHash);
        $behaviours = $map[$method];
        if(!$behaviours) {
            $behaviours = array();
        }
        return $behaviours;
    }
    
}
