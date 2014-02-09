<?

namespace Infuso\Core;

/**
 * Класс, реализующий карту поведений
 **/
class BehaviourMap {

	public function getList($class) {
	
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

		usort($behaviours, function($a,$b) {
		    return $a::behaviourPriority() - $b::behaviourPriority();
		});
		
		return $behaviours;
	
	}

	public function getMap($class) {
	
	    $key = "behaviours-map-".$class;
	    $data = Mod::service("cache")->get($key);

	    if($data === null) {
	        $data = self::getMapNocache($class);
	        Mod::service("cache")->set($key,$data);
	    }
	    
	    return $data;
	
	}

    public static function getMapNocache($class) {
    
        $behaviours = self::getList($class);
    
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
    
    public static function routeMethod($class,$method) {
        $map = self::getMap($class);
        $behaviours = $map[$method];
        if(!$behaviours) {
            return;
        }
        return end($behaviours);
    }
    
    public function getBehavioursForMethod($class,$method) {
        $map = self::getMap($class);
        $behaviours = $map[$method];
        if(!$behaviours) {
            $behaviours = array();
        }
        return $behaviours;
    }
    
}
