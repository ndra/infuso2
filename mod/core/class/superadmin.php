<?

namespace Infuso\Core;
use Infuso\Core\File as File;

class Superadmin extends Controller {

    private static $checked = false;
	private static $checkResult = false;
	private static $storedPassword = null;

    public static function changePassword($p) {

        $p1 = trim($p["p1"]);
        $p2 = trim($p["p2"]);
        if($p1!=$p2) {
            return;
        }

        $hash = Crypt::hash($p1);
        File::get(mod::app()->confPath()."/__superadmin.txt")->put($hash);
    }

    /**
     * Проверяет является ли пользователь суперадмином
     * Попробовать переписать с писпользование класса Session
     **/
    public static function check() {

        if(!self::$checked) {

            self::$checked = true;

	        @session_start();
            $password = array_key_exists("mod:superadminPasswordHash", $_SESSION) ? trim($_SESSION["mod:superadminPasswordHash"]) : null;
	        $hash = self::getStoredPassword();

	        if($hash === "0000") {
	            self::$checkResult = ($hash===$password);
	        } else {
	            self::$checkResult = Crypt::checkHash($hash,$password);
            }
		}

		return self::$checkResult;
    }

    /**
     * Возвращает хэш пароля, сохраненный в файле __superadmin.txt
     **/
    public static function getStoredPassword() {

        if(self::$storedPassword === null) {
            self::$storedPassword = trim(file::get(mod::app()->confPath()."/__superadmin.txt")->data());
        }

        return self::$storedPassword;
    }

    /**
     * @todo не работает!
     **/
    public static function is0000() {
        return self::getStoredPassword() === "0000";
    }

	public static function postTest() {
		return true;
	}

    /**
     * Пробует авторизоваться в качестве суперадмина
     **/
    public static function post_logout() {
		self::logout();
	}

    public static function logout() {
        @session_start();
        unset($_SESSION["mod:superadminPasswordHash"]);
    }

    public static function post_login($p) {
		self::login($p["password"]);
	}

    public static function login($password) {
        @session_start();
        $_SESSION["mod:superadminPasswordHash"] = $password;
        self::$checked = false;
    }

}
