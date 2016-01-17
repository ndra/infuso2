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
	 * Возвращает экшн (класс mod_action)
	 **/
	public static function action($a,$b=null,$c=array()) {
		return action::get($a,$b,$c);
	}

	public static function session($key, $val=null) {
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
	 * Возвращает текущее приложение
	 **/
	public function app() {
	    return \infuso\core\app::current();
	}

}
