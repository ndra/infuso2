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
	    app()->tm()->noindex();
		if(self::$showLogin) {
            app()->tm("admin:not_logged_in")->exec();
		} else {
			app()->httpError(404);
		}
	}

	/**
	 * Выводит шапку админки
	 **/
	public static function header($title = "") {
    
        //if(!app()->user()->checkAccess("admin:showInterface")) {
        ///    self::fuckoff();        
        //}
    
	    $tmp = app()->tm();
	    $tmp->noindex();
		$tmp->param("title",$title);
		$tmp->param("back-end",1);
		$tmp->exec("/admin/header");
	}

	/**
	 * Выводит подвал админки
	 **/
	public static function footer() {
		app()->tm()->exec("/admin/footer");
	}

	/**
	 * Вызывает виджет горизонтального администраторского меню
	 **/
	public static function menu() {
		app()->tm("admin:menu")->exec();
		app()->tm()->param("admin-header",true);
	}

}
