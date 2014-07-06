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

	/**
	 * Выводит шапку админки
	 **/
	public static function header($title="") {
	    $tmp = Core\Mod::app()->tm();
	    $tmp->noindex();
		$tmp->param("title",$title);
		$tmp->param("back-end",1);
		$tmp->exec("/admin/header");
	}

	/**
	 * Выводит подвал админки
	 **/
	public static function footer() {
		Core\Mod::app()->tm()->exec("/admin/footer");
	}

	/**
	 * Вызывает виджет горизонтального администраторского меню
	 **/
	public static function menu() {
		\tmp::exec("admin:menu");
		\tmp::param("admin-header",true);
	}

}
