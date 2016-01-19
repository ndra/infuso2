<?

namespace Infuso\Cms\Admin;
use Infuso\Core;

/**
 * Дефолтный контроллер админки
 **/
class Admin extends Core\Controller implements Core\Handler {

	private static $showLogin = true;
	
	/**
	 * Эта веселая функция показывает форму авторизации и прекращает дальнейшую работу скрипта
	 * @todo wtf ::$showLogin
	 **/
	public static function fuckoff() {
	    app()->tm()->noindex();
		if(self::$showLogin) {
            throw new \Infuso\Core\Exception\NotAuthorized();
		} else {
			app()->httpError(404);
		}
	}
    
    /**
     * @handler = infuso/exception
     * @todo Доработать чтобы реагировала не на все исключения     
     **/         
    public function onException($event) {
        if(is_a($event->param("exception"), "Infuso\\Core\\Exception\\NotAuthorized")) {
            $event->stop();
            app()->tm("admin:not_logged_in")->exec();
        }
    }

	/**
	 * Выводит шапку админки
	 **/
	public static function header($title = "") {
    
        if(!app()->user()->checkAccess("admin:showInterface")) {
            self::fuckoff();        
        }
    
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
