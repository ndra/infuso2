<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Контроллер подписки на рассылку
 **/
class Subscribe extends Core\Controller {

	public function indexTest() {
	    return true;
	}
	
    public function postTest() {
        return true;
    }
    
    public function controller() {
	    return "subscribe";
	}
	
	/**
     * Вывод главной страницы подписки
     **/
    public static function index() {
		app()->tm()->add("center", "/site/subscribe/index");
        app()->tm("/site/layout")->exec();
   
    }
    
    /**
     * Вывод главной страницы подписки
     **/
    public static function index_unsubscribe() {
		app()->tm()->add("center", "/site/subscribe/unsubscribe");
        app()->tm("/site/layout")->exec();
   
    }
    
     /**
     * показываем форму подписки
     **/
    public function post_load($p) {
        return app()->tm("/site/subscribe/ajax")->getContentForAjax();
    }
    
	
}
