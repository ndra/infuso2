<?

namespace Infuso\Cms\Admin;
use Infuso\Core;

/**
 * Дефолтный контроллер админки
 **/
class Admin extends Core\Controller {

	private static $showLogin = true;

	/**
	 * Эта веселая функция показывает форму авторизации и прекращает дальнейшую работу скрипта
	 * @todo wtf ::$showLogin
	 **/
	public static function fuckoff() {
	    \tmp::noindex();
		if(self::$showLogin) {
            \tmp::exec("admin:not_logged_in");
		} else {
			\mod::app()->httpError(404);
		}
	}

	public static function indexTest() {
		return user::active()->checkAccess("admin:showInterface");
	}

	public static function index($p1=null) {
		admin::header("Администрирование");
		tmp::exec("admin:startPage");
		tmp::exec("admin:footer");
	}

	public static function indexFailed() {
		admin::fuckoff();
	}

	/**
	 * Выводит шапку админки
	 **/
	public static function header($title="") {
	
	    $tmp = Core\Mod::app()->tmp();
	
	    $tmp->noindex();
		$tmp->param("title",$title);
		$tmp->param("back-end",1);
		$tmp->exec("/admin/header");
	}

	/**
	 * Выводит подвал админки
	 **/
	public static function footer() {
		Core\Mod::app()->tmp()->exec("/admin/footer");
	}

	/**
	 * Вызывает виджет горизонтального администраторского меню
	 **/
	public static function menu() {
		\tmp::exec("admin:menu");
		\tmp::param("admin-header",true);
	}

}
