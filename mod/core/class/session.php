<?

namespace Infuso\Core;

/**
 * Класс-обертка для работы с сессией
 **/
class Session extends Service {

	private static $started;

    public function defaultService() {
        return "session";
    }

    public static function serviceFactory() {
        return new self();
    }

	public static function start() {
		if(self::$started) {
		    return;
        }
		session_start();
		self::$started = true;
	}

	public static function get($key) {
		self::start();
		return $_SESSION[$key];
	}

	public static function set($key,$val) {
		self::start();
		$_SESSION[$key] = $val;
	}

    public function session() {
        self::start();
        return new util_array($_SESSION);
    }

}
