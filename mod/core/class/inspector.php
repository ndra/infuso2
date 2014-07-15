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
        if(service("classmap")->testClass($this->className(), "infuso\\core\\component")) {
        
            foreach(\Infuso\Core\BehaviourMap::getList($this->className(),array()) as $behaviour) {                        
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
	                $ret[$method->getName()][$match[1]] = trim($match[2]);
	            }
	        }
	    }

	    return $ret;
	
	}

}
