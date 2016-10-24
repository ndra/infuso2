<?

namespace Infuso\Core;

class Component {

    /**
     * Параметры компонента
    **/
    private $params = array();
    
    private $paramsLoaded = false;
    
    private $lockedParams = array();

    private $componentID = null;
    
    private $behaviours = array();

    /**
     * Добавляет поведение в класс
     * Аргумент - имя класса
     * @return $this
     **/
    public final function addBehaviour($behaviour) {
        if(!array_key_exists($behaviour, $this->behaviours)) {
            $this->behaviours[] = $behaviour;
        }
        return $this;
    }
    
	/**
	 * Возвращает хэш добавленных поведений
	 * Одинаковый хэш - одинаковый массив поведений
	 **/
	public final function behaviourHash() {
	    return implode("|", $this->behaviours);
	}
	
	private static $behaviourClosures = array();
    
    /**
     * Возвращает замыкание метода $method класса $behaviour
     * При этом контекст замыкания - $this - этот объект
     * todo Оптимизация скорости, кэширование
     **/
    public function behaviourMethodFactory($behaviour, $method) {
    
        // На всякий случай, переведем метод в маленький регистр
        $method = strtolower($method);
        
    	$key = $behaviour.":".$method;
    
		Profiler::beginOperation("core", "create closure", get_class($this)." - ".$key);
		
		if(!$this->behaviourClosures[$key]) { 
    
			$reflectionClass = new \ReflectionClass($behaviour);
			$reflectionMethod = $reflectionClass->getMethod($method);
			$closure = $reflectionMethod->getClosure(new $behaviour);
            if($reflectionMethod->isStatic()) {
                $this->behaviourClosures[$key] = $closure;
            } else {
                $this->behaviourClosures[$key] = $closure->bindTo($this);
            }
		                    
		}
		
		Profiler::endOperation("");
		
		return $this->behaviourClosures[$key];
    }

    /**
      * Возвращает массив замыканий методов $method из поведений, прикрепленных к объекту
      * Методы сортируются по приоритету поведений так что первый элемент массива
      * будет из поведения с наибольшим приоритетом
      **/
    public final function behaviourMethods($method) {
    
        $ret = array();

        foreach(BehaviourMap::getBehavioursForMethod(get_class($this), $method, $this->behaviours, $this->behaviourHash()) as $bclass) {
			$ret[] = $this->behaviourMethodFactory($bclass, $method);
        }
        
        return $ret;
    }

    /**
     * Магический метод, который вызывается при обращении к несуществующему методу класса.
     * С помощью данного метода реализуется механизм поведений
     **/
    public final function __call($fn, $params) {
    
        $behaviourClass = BehaviourMap::routeMethod(get_class($this), $fn, $this->behaviours, $this->behaviourHash());
        if($behaviourClass) {
            $fn = $this->behaviourMethodFactory($behaviourClass, $fn);
            return call_user_func_array(array($fn,"__invoke"), $params);
        }
    
        // Пытаемся вызвать метод _fn
        $fn3 = "_".$fn;
        if(method_exists($this, $fn3)) {
            return call_user_func_array(array($this, $fn3), $params);
        }
        
		// Пытаемся вызвать дата-врапперы
        $wrappers = $this->dataWrappers();

        if(array_key_exists($fn, $wrappers)) {

			$split = function($str) {
		        $ret = array();
		        foreach(explode(",", $str) as $part) {
		            if(trim($part) !== "") {
		                $ret[] = $part;
		            }
		        }
		        return $ret;
		    };

            $wrappers = $split($wrappers[$fn]);
            foreach($wrappers as $wrapper) {

                if(preg_match("/^mixed(\/([a-z0-1\_]*))?/",$wrapper,$matches)) {

                    $wrapperMethod = $matches[2];
                    if(!$wrapperMethod)
                        $wrapperMethod = "param";

                    if(sizeof($params)==1) {
                        $this->$wrapperMethod($fn,$params[0]);
                        return $this;
                    } elseif(sizeof($params)==0) {
                        return $this->$wrapperMethod($fn);
                    } else {
                        throw new \Exception("method $fn defined as wrapper and must have zero or one argument. ");
                    }

                    return;
                }
            }
        }

        // Вызываем метод componentCall()
        // Его можно переопределить и использовать как __call для компонента
        // (для обработки методов, которых нет в компоненте и в поведениях)
        // По умолчанию componentCall выбросить исключение.
        return $this->componentCall($fn,$params);
    }
    
    public final static function __callStatic($fn,$params) {

        $behaviourClass = BehaviourMap::routeMethod(get_called_class(),$fn,array(),"");
        if($behaviourClass) {
            return call_user_func_array(array($behaviourClass, $fn),$params);
        }

        // Пытаемся вызвать метод _fn
        $_fn = "_".$fn;
        
        if(method_exists(get_called_class(),$_fn)) {
            return call_user_func_array(array(get_called_class(),$_fn),$params);
        }
        
        throw new \Exception("Unknown static method \"$fn\"");

    }

    public function componentCall($fn) {
        $class = get_class($this);

        $b = debug_backtrace(false);
        $line = $b[2]["line"];
        $file = $b[2]["file"];

        throw new \Exception("Call undefined method $class::$fn in $file on line $line");
    }

    /**
     * Проверяет наличие метода у компонента
     * Поиск производится в самом компоненте и в прикрепленных поведениях
     * @todo когда дело доходит до дата-врапперов
     **/
    public final function methodExists($fn) {

        if(method_exists($this, $fn)) {
            return true;
		}

        if(method_exists($this, "_".$fn)) {
            return true;
		}

        $behaviourClass = BehaviourMap::routeMethod(get_class($this), $fn, $this->behaviours, $this->behaviourHash());
		if($behaviourClass) {
		    return true;
		}
		
		return false;
		
    }
    
    /**
     * @return Массив поведений, который дорбавляются объекту по умолчанию
     **/
    public function defaultBehaviours() {
        return array();
    }

    /**
     * Магическая функция __clone клонирует поведения
     * сделать чтобы поведения клонировались
     **/
    public final function __clone() {
    }

    /**
     * Загрузка параметров из конфигурации YAML
     **/
    private function loadParams() {
    
        if($this->paramsLoaded) {
            return;
        }

        $this->paramsLoaded = true;

        // Загружаем параметры по умолчанию
        $this->params($this->initialParams());

		// Довавляем параметры из конфигурации компонентов
        $params = $this->componentConf("params");
        if(is_array($params)) {
            foreach($params as $key => $val) {
                $this->param($key,$val);
            }
        }

    }

    /**
     * Блокирует параметр $key для изменения
     **/
    public function lockParam($key) {
        $this->lockedParams[] = $key;
    }

    /**
     * Возвращает параметр конфигурации компонента
     **/
    public final function componentConf() {
        $args = func_get_args();
        array_unshift($args,strtolower(get_class($this)));
        array_unshift($args,"components");
        return call_user_func_array(array("\infuso\core\conf","general"),$args);
    }

    /**
     * Возвращает набор начальныйх параметров компонента.
     * начальные параметры перекрываются параметрами из components.yml
     **/
    public function initialParams() {
        return array();
    }

    /**
     * Получить параметр, задать параметр
     **/
    public final function &param($key=null,$val=null) {

        $this->loadParams();

        if(func_num_args()==0) {
            return $this->params;
        } elseif (func_num_args() == 1) {

            if(is_array($key)) {
                foreach($key as $a=>$b) {
                    $this->param($a,$b);
                }
                return $this;
            }

            // Мы возвращаем значение по ссылке
            // Если возвращать по ссылке несуществующие элементы массива, php создает их на лету
            // и записывает в них нули
            // Чтобы этого не произошло - проверяем наличие ключа у массива
            if(array_key_exists($key,$this->params)) {
                return $this->params[$key];
            } else {
                return null;
            }

        }  elseif(func_num_args() == 2) {
            if(!in_array($key,$this->lockedParams)) {
                $this->params[$key] = $val;
            }
            return $this;
        }

    }

    /**
     * При вызове без параметров выбросит исключение
     **/
    public final function params($params=null) {

        $this->loadParams();

        if(func_num_args()==0) {
            return $this->params;
        }

        if(func_num_args() == 1) {

            if(!is_array($params)) {
                throw new \Exception("mod_component::params() called with single argument of type ".gettype($params).": '$string', expecting array" );
            }

            foreach($params as $key => $val) {
                $this->param($key,$val);
            }
            return $this;
        }

    }

    /**
     * Ставит задачу отложенного вызова метода $method
     **/
    public function defer($method) {
        Defer::add($this, $method);
    }

	/**
	 * Возвращает id компонента, чтобы как-то отличить уникальные инстансы
	 **/
    public function getComponentID() {
        if(!$this->componentID) {
            $this->componentID = \Mod::id();
        }
        return $this->componentID;
    }

    /**
     * Возвращает массив дата-врапперов
     * Переопределите этот метод для создания собственных врапперов
     * return array(
     *   "myparam" => "mixed", // Враппер к параметру
     *   "myvalue" => "mixed/data" // Враппер к ->data() для reflex
     * )
     **/
    public function dataWrappers() {
        return array();
    }

    /**
     * Выполняет код в контексте объенкта
     * Разворачивает в область видимости кода массив переменных $params
     **/
    public function evalCode() {
        if(func_num_args()==2 && is_array(func_get_arg(1))) {
            extract(func_get_arg(1));
        }
        return eval(func_get_arg(0));
    }
    
    /**
     * Возвращает конфигурацию объекта из YAML с настройками
     **/
	public static function confDescription() {
		return array();
	}
	
    /**
     * @todo рефакторить хардкод
     **/
    public function plugin($name) {

        switch($name) {
            case "log":
                $plugin = new \Infuso\Cms\Reflex\Plugin\Log($this);
                break;
            case "meta":
                $plugin = new \Infuso\Cms\Reflex\Plugin\Meta($this);
                break;
            case "editor":
                $plugin = new \Infuso\Cms\Reflex\Plugin\Editor($this);
                break;
            case "route":
                $plugin = new \Infuso\Cms\Reflex\Plugin\Route($this);
                break;
        }
        
        return $plugin->factory();

    }

    /**
	 * @todo сделать кэширование
	 **/
    public static final function inspector() {
        return new \infuso\core\inspector(get_called_class());
    }
    
    public function behaviours() {
        return BehaviourMap::getBehavioursForMethod(get_class($this), $this->behaviours, $this->behaviourHash());
    }
    
    /**
     * @todo сделать кэширование
     * Имеет ли класс интерфейс
     * Учитываются также интерфейсы поведений
     **/
    public function hasInterface($interface) {
        if(is_a($this, $interface)) {
            return true;
        }
        
        foreach($this->behaviours() as $behaviour) {
            if(is_a($behaviour, $class)) {
                return true;
            }
        }
        
        return false;
        
    }

}
