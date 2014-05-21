<?

namespace Infuso\Core;

/**
 * @todo убрать из класса контроллер
 **/
class Mod extends \Infuso\Core\Component {

	private static $debug = null;
	


	/**
	 * Включен ли режим отладки
	 * @todo сделать настройки режима отладки
	 **/
	public function debug() {
	
	    return true;
	
	    if(self::$debug===null) {
	    
	        self::$debug = false;
	
		    if(!conf::general("mod:debug")) {
				self::$debug = false;
				return self::$debug;
		    }

		    if(!superadmin::check()) {
		        self::$debug = false;
				return self::$debug;
		    }
		    
		    self::$debug = true;
			return self::$debug;
		        
		}
	
		return self::$debug;
	}

	/**
	 * @return Возвращает случайный хэш длины $length
	 **/
	public static function id($length=30) {
		$chars = "1234567890qwertyuiopasdfghjklzxcvbnm";
		$ret = "";
		for($i=0;$i<$length;$i++) {
		    $ret.= $chars[rand()%strlen($chars)];
		}
		return $ret;
	}

	/**
	 * Заносит сообщение в лог
	 **/
	public function trace($message) {
        mod::fire("infuso/trace", array(
            "message" => $message,
        ));
	}

	/**
	 * Возвращает экшн (класс mod_action)
	 **/
	public static function action($a,$b=null,$c=array()) {
		return action::get($a,$b,$c);
	}

	/**
	 * Создает и возвращает экземпляр класса mod_event
	 **/
	public function event($eventName,$params=array()) {
		return new event($eventName,$params);
	}

	/**
	 * Вызывает событие
	 * @param string $eventName Имя события
	 * @param array $params Параметры события
	 **/
	public function fire($eventName,$params=array()) {
		$event = self::event($eventName,$params);
		$event->fire();
		return $event;
	}

	/**
	 * Обертка для mod_cooke::set() и mod_cookie::get()
	 **/
	public static function cookie($key,$val=null) {
  		if(func_num_args()==1) {
		    return mod_cookie::get($key);
		}
		if(func_num_args()==2) {
	    	mod_cookie::set($key,$val);
	    }
	}

	public static function session($key,$val=null) {
		if(func_num_args()==1) {
		    return \mod_session::get($key);
		}
	    \mod_session::set($key,$val);
	}

	/**
	 * @param $url string
	 * @return object mod_url При вызове без параметра, вернет текущий урл
	 **/
	public function url($url=null) {
		if(func_num_args()==0) {
		    return url::current();
		}
		return url::get($url);
	}
	
	/**
	 * Возвращает службу по ее имени
	 **/
	public function service($serviceName) {
     	Profiler::beginOperation("core","service",$serviceName);
	    $ret = mod::app()->service($serviceName);
		Profiler::endOperation("core","service",$serviceName);
	    return $ret;
	}
	
	/**
	 * Возвращает текущее приложение
	 **/
	public function app() {
	    return \infuso\core\app::current();
	}

}
