<?

namespace infuso\core;

class Component {

    /**
     * Параметры компонента
     *
     * @var array
    **/
    private $params = array();
    private $paramsLoaded = false;
    private $lockedParams = array();

    private $componentID = null;

    /**
     * Добавляет поведение в класс
     * Аргументом - имя класса
     * @return $this
     **/
    public final function addBehaviour($behaviour) {
    
        echo $behaviour;
    

        return $this;
    }

    /**
     * @return array Возврвщает массив поведений объекта
     **/
    public final function behaviours() {
    
        \util::backtrace();
    
        $ret = array();
        foreach(BehaviourMap::getList(get_class($this)) as $bclass) {
            $ret[] = new $bclass;
        }
        return $ret;
    }
    

    /**
     * Вызывает метод $fn всех прикрепленных к объекту поведений (метод самого объекта не вызывается)
     * Поведения вызываются в порядке добавления: первым вызовется поведение, добавленное первым
     * @return array с объединением результатов вызванных методов (array_merge)
     **/
    public function callBehaviours($fn) {
    
        $args = func_get_args();
        array_shift($args);
    
        $ret = array();

        foreach(BehaviourMap::getBehavioursForMethod(get_class($this),$fn) as $bclass) {
            $behaviour = new $bclass;
            $items = call_user_func_array(array($behaviour,$fn),$args);
			if(is_array($items)) {
                foreach($items as $item) {
                    $ret[] = $item;
                }
            }
        }
        
        return $ret;
    
        /*return;
    
        $args = func_get_args();
        array_shift($args);

        $ret = array();
        foreach(array_reverse($this->behaviours()) as $b)
            if(method_exists($b,$fn)) {
                $items = call_user_func_array(array($b,$fn),$args);
                if(is_array($items)) {
                    foreach($items as $item) {
                        $ret[] = $item;
                    }
                }
            }
        return $ret; */
    }

    /**
     * Магический метод, который вызывается при обращении к несуществующему методу класса.
     * С помощью данного метода реализуется механизм поведений
     **/
    public final function __call($fn,$params) {
    
        $behaviourClass = BehaviourMap::routeMethod(get_class($this),$fn);
        if($behaviourClass) {
            $behaviour = new $behaviourClass;
            $behaviour->registerComponent($this);
            return call_user_func_array(array($behaviour,$fn),$params);
        }
    
        // Пытаемся вызвать метод _fn
        $fn3 = "_".$fn;
        if(method_exists($this,$fn3)) {
            return call_user_func_array(array($this,$fn3),$params);
        }

        // Пытаемся вызвать дата-врапперы
        $wrappers = $this->dataWrappers();

        if(array_key_exists($fn,$wrappers)) {
        
			$split = function($str) {
		        $ret = array();
		        foreach(explode(",",$str) as $part) {
		            if(trim($part)!=="") {
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
                        throw new Exception("method $fn defined as wrapper and must have zero or one argument. ");
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

    public function __get($key) {
        $class = get_class($this);
        throw new \Exception("access to undefined property $class::$key");
    }

    public function __set($key,$val) {
        $class = get_class($this);
        throw new \Exception("access to undefined property $class::$key");
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
     **/
    public final function methodExists($fn) {

        if(method_exists($this,$fn)) {
            return true;
		}

        if(method_exists($this,"_".$fn)) {
            return true;
		}

        foreach($this->behaviours() as $b) {
            if($b->routeBehaviourMethod($fn)) {
                return true;
			}
		}
    }


    
    /**
     * @return Массив поведений, который дорбавляются объекту по умолчанию
     **/
    public function defaultBehaviours() {
        return array();
    }

    /**
     * Магическая функция __clone клонирует поведения
     **/
    public final function __clone() {
        foreach($this->behaviours() as $key => $b) {
            $b = clone $b;
            $b->registerComponent($this,$this->nextBehaviourPriority);
            $this->nextBehaviourPriority++;
            $this->___behaviours[$key] = $b;
        }
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

        $params = $this->componentConf("params");
        
        if(is_array($params)) {
            foreach($params as $key=>$val) {
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
    public function componentConf() {
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
        }

        if(func_num_args()==1) {

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

        }

        if(func_num_args()==2) {
            if(!in_array($key,$this->lockedParams)) {
                $this->params[$key] = $val;
            }
            return $this;
        }

    }

    /**
     * При вызове без параметров выозвращает
     **/
    public final function params($params=null) {

        $this->loadParams();

        if(func_num_args()==0) {
            return $this->params;
        }

        if(func_num_args()==1) {

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
        Defer::add($this,$method);
    }

	/**
	 * Возвращает id компонента, чтобы как-то отличить уникальные инстансы
	 **/
    public function getComponentID() {
        if(!$this->componentID) {
            $this->componentID = util::id();
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

    public static final function inspector() {
        return new \infuso\core\inspector(get_called_class());
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
    
	public function confDescription() {
		return array();
	}

}
