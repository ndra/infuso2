<?

namespace Infuso\Core;

/**
 * Класс, реализующий карту поведений
 **/
class BehaviourMap {

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
    
        echo "************************";
    
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
    
        $ret = array();
        foreach($behaviours as $b) {
            $r = new \ReflectionClass($b);
            foreach($r->getMethods() as $method) {
                if($method->getDeclaringClass()->getName() == "Infuso\\Core\\Behaviour") {
					break;
                }
                $ret[$method->getName()] = $r->getName();
            }
        }
        
        return $ret;
    }
    
    public static function routeMethod($class,$method) {
        $map = self::getMap($class);
        return $map[$method];
    }

}
