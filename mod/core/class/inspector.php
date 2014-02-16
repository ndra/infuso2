<?

namespace infuso\core;

/**
 * Класс-инспектор (похож на ReflectionClass)
 **/
class inspector {

	private $className;

	public function __construct($className) {
	    $this->className = $className;
	}
	
	public function bundle() {
	    return mod::service("classmap")->getClassBundle($this->className);
	}
	
	public function className() {
	    return $this->className;
	}
	
	public function path() {
	    return mod::service("classmap")->classPath($this->className);
	}
	
	/**
	 * Возвращает массив аннотаций для класса
	 **/
	public function annotations() {
	
	    $class = new \ReflectionClass($this->className());
	    $ret = array();
	    
	    foreach($class->getMethods() as $method) {
	        $comments = $method->getDocComment();
	        echo "<pre>";
	        if(preg_match_all("/\*\s*\@([a-z0-9]+)\s*=\s*(.*)/iu",$comments,$matches,PREG_SET_ORDER )) {
	            foreach($matches as $match) {
	                $ret[$method->getName()][$match[1]] = trim($match[2]);
	            }
	        }
	        echo "<hr/>";
	    }
	    
	    return $ret;
	
	}

}
