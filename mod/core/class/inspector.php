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
	    return service("classmap")->getClassBundle($this->className);
	}
	
	public function className() {
	    return $this->className;
	}
	
	public function path() {
	    return service("classmap")->classPath($this->className);
	}
    
    /**
     * Возвращает описание класса из phpdoc
     **/         
    public function docComment() {       
        $reflection = new \ReflectionClass($this->className());
        return $reflection->getDocComment();     
    }
	
	/**
	 * Возвращает массив аннотаций для класса
	 * @todo неплохо бы сделать кэширование
	 **/
	public function annotations() {
	
	    $class = new \ReflectionClass($this->className());
	    $ret = array();
       
        // Аннотации поведений
        if(is_subclass_of($this->className(), "infuso\\core\\component")) {         
            foreach(\Infuso\Core\BehaviourMap::getBehaviours($this->className(), array(), "") as $behaviour) {                        
                $behaviour = new \ReflectionClass($behaviour);
        	    foreach($behaviour->getMethods() as $method) {
        	        $comments = $method->getDocComment();                    
        	        if(preg_match_all("/\*\s*\@([a-z0-9\_\-]+)\s*=\s*(.*)/iu",$comments,$matches,PREG_SET_ORDER )) {
        	            foreach($matches as $match) {                            
        	                $ret[$method->getName()][$match[1]] = trim($match[2]);
        	            }
        	        }
        	    }
            }
        }
        
        // Аннотации собственно класса          
	    foreach($class->getMethods() as $method) {
	        $comments = $method->getDocComment();
	        if(preg_match_all("/\*\s*\@([a-z0-9\_\-]+)\s*=\s*(.*)/iu",$comments,$matches,PREG_SET_ORDER )) {
	            foreach($matches as $match) {
                    $name = $method->getName();
                    if(preg_match("/^_/", $name)) {
                        $name = preg_replace("/^_/", "", $name);
                        if(!isset($ret[$name][$match[1]])) {
                            $ret[$name][$match[1]] = trim($match[2]);
                        }
                    } else {
                        $ret[$name][$match[1]] = trim($match[2]);
                    }
	            }
	        }
	    }

	    return $ret;
	
	}
    
    public function todos() { 
    
        $ret = array();
        $class = new \ReflectionClass($this->className());                              
        foreach($class->getMethods() as $method) {
	        $comments = $method->getDocComment();                    
	        if(preg_match_all("/\*\s*\@todo\s*(.*)/iu", $comments, $matches, PREG_SET_ORDER )) {
	            foreach($matches as $match) {                            
	                $ret[$method->getName()].= trim($match[1]);
	            }
	        }
	    }
        return $ret;
    }

}
