<?

namespace Infuso\Core;

class Action extends Component {

    private $className = "";
    private $action = "";
    private $ar = "";

    public function __construct($className=null,$action=null,$params = array()) {
    
        if(!trim($action)) {
            $action = "index";
        }
        $this->action = $action;
        $this->className = $className;
        
        if($params) {
        	$this->params($params);
        }
    }

    public function get($class,$action=null,$params=array()) {
        return new action($class,$action,$params);
    }

    /**
     * Преобразует строку в экшн
     * myclass/action/a/123/b/xxx
     * return @class mod_action
     **/
    public function fromString($str) {

        $path = util::splitAndTrim($str,"/");
        $class = array_shift($path);
        $action = array_shift($path);

        $key = null;
        $params = array();
        $n = 0;
        foreach($path as $item) {
            if($n%2==0) {
                $key=$item;
            } else {
                $params[$key] = $item;
            }
            $n++;
        }
        return mod_action::get($class,$action,$params);
    }

    public function canonical() {
        $ret = "";
        $ret.= $this->className();
        $ret.= "/".$this->action();
        foreach($this->params() as $key => $val) {
            $ret.= "/$key/$val";
        }
        return $ret;
    }
    
    /**
     * Возвращает информацию о маршруте
     **/
    public function ar($ar = null) {
    
        if(func_num_args()==0) {
        	return $this->ar;
        } elseif(func_num_args()==1) {
            $this->ar = $ar;
            return $ar;
        }
    }

    /**
     * Возвращает хэш экшна, состоящий из класса, метода и параметров
     * Хэш используется в таблице роутов для быстрого поиска
     * */
    public function hash() {

        $controller = $this;
        $seek = $controller->className();
        if($a = $controller->action()) {
            $seek.= "/".$controller->action();
        }
            
        $params = $controller->params();

        foreach($params as $key=>$val) {
            $params[$key] = $val."";
        }

        sort($params);
        $seek.= serialize($params);
        return $seek;
    }

    /**
     * Может ли активный пользователь выполнить этот экшн?
     **/
    public function test() {

        if(!mod::app()->service("classmap")->testClass($this->className(),"infuso\\core\\controller")) {
            return false;
		}

        $class = "\\".$this->className();
        $obj = new $class;

        if(!call_user_func($this->testCallback(),$this->params())) {
            return false;
		}

        if($obj->methodExists($this->method())) {
            return true;
        }

        return false;
    }

    /**
     * Возвращает экшн, который выполняется в данное время
     **/
    public static function current() {
		return mod::app()->action();
    }
    
    public function exists() {
        return (bool)$this->className();
    }

    /**
     * Выполняет этот экшн
     * Предварительно проверяет возможность его выполнения, вызывая метод test
     **/
    public function exec() {     
        
        if(!$this->test()) {  
			call_user_func($this->failCallback(),$this->params());
        } else {
            if(mod::app()->eventsEnabled()) {
	            mod::fire("mod_beforeAction",array(
	                "action" => $this,
	            ));
			}
            Profiler::addMilestone("before action");
            call_user_func($this->callback(),$this->params());
        }

    }

    public function className() {
        return $this->className;
    }

    public function action() {
        return $this->action;
    }

    public function callback() {
        $method = $this->method();
        $class = $this->className();
        $obj = new $class;
        return array($obj,$method);
    }

    public function method() {
        return $this->action()=="index" ? "index" : "index_".$this->action();
    }

    public function testCallback() {
        $class = $this->className();
        $obj = new $class;
        return array($obj,"indexTest");
    }

    public function failCallback() {
        $class = $this->className();
        $obj = new $class;
        return array($obj,"indexFailed");
    }

    public function __toString() {
        return $this->url();
    }
    
    public function url() {
        return $this->app()->service("route")->actionToURL($this);
    }

    public function redirect() {
        header("location:{$this->url()}");
        die();
    }

}
