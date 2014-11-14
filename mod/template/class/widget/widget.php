<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Базовый абстрактный класс для всех виджетов
 **/
abstract class Widget extends Generic {

	/**
	 * @return Возвращает объект виджета
	 */
	public final static function get($name) {
	
    	$classmap = Core\Mod::service("classmap");
    	
    	if($classmap->testClass($name,Widget::inspector()->classname())) {
    	    return new $name;
    	}
    
    	$name = strtolower($name);

    	/*foreach($classmap->classes(Widget::inspector()->classname()) as $class) {
    	    if($class::inspector()->bundle()->path() == $current->bundle()->path()) {
    	        $reflect = new \ReflectionClass($class);
    			if (strtolower($reflect->getShortName()) === $name) {
    			    return new $class;
                }
    	    }
    	} */
    	
    	foreach($classmap->classes(Widget::inspector()->classname()) as $class) {
    	    if($class::alias() == $name) {
    	        return new $class;
    	    }
    	}
    	
    	throw new \Exception("Cannot find widget '{$name}'");
    	
	}

	/**
	 * @return Название виджета
	 * Вы должны определить этот метод
	 **/
	abstract function name();

	/**
	 * Вызов виджета
	 * Вы должны определить этот метод
	 **/
	abstract public function execWidget();
	
	public function alias() {
		return "";
	}

	/**
	 * @return array Возвращает массив с виджетами
	 **/
	public final function all() {
	    $ret = array();
	    foreach(mod::classes("tmp_widget") as $class) {
	        $ret[] = new $class;
	    }
	    return $ret;
	}

	private static $stack = array();

	public final function begin($params=array()) {
		foreach($params as $key=>$val)
			$this->param($key,$val);
		self::$stack[] = $this;
		ob_start();

		return $this;
	}

	public final function end() {
		$widget = array_pop(self::$stack);
		$content = ob_get_clean();
		$this->param("content",$content);
		$widget->exec($widget->param());
	}

	public final function exec() {
		$this->execWidget($this->param());
	}

}
