<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use \Infuso\Heapit\Model;

class Bargain extends Base {

    public function index() {
        app()->tm("/heapit/bargain-list")->exec();
    }
    
    public function index_add() {
        app()->tm("/heapit/bargain-new")->exec();
    }
    
    /**
     * Создает сделки
     **/
    public static function post_new($p) {
        $bargain = Core\Mod::service("ar")
            ->create("Infuso\\Heapit\\Model\\Bargain", $p["data"]);
        return $bargain->url();
    }
    
    /**
     * Сохраняет данные о сделке
     **/         
    public static function post_save($p) {
        $bargain = Model\Bargain::get($p["bargainId"]);
        $bargain->setData($p["data"]);
        app()->msg("Сохранено");
    }
    
    /**
     * Изменяет дату созвона
     **/
    public function post_updateCallTime($p) {
        $callTime = $p["data"]["callTime"];
        $comment = trim($p["data"]["comment"]);
        
        if(\util::str($comment)->length() < 3) {
            app()->msg("Укажите причину переноса даты", 1);
			return false;
        }
        
        $bargain = Model\Bargain::get($p["bargainId"]);
        if(!$bargain->exists()) {
			app()->msg("Несуществующая сделка, обратитесь к программистам.", 1);
			return false;
        }
        
		$bargain->data("callTime", $callTime);
		$bargain->comments()->create(array(
		    "text" => "Связаться ".(\util::date($callTime)->date()->text())." Причина: $comment",
		    "author" => app()->user()->id(),
		));
		return true;
        
    }
    
    /**
     * Изменяет дату созвона
     **/
    public function post_callTimeContent($p) {
        $bargain = Model\Bargain::get($p["bargainId"]);
		return app()->tm("/heapit/bargain/content/contact/editor")
		    ->param("bargain", $bargain)
		    ->getContentForAjax();
    }

    /**
     * Возвращает html-код списка сделок
     **/
    public function post_search($p) {

        $bargains = \Infuso\Heapit\Model\Bargain::all();
        $bargains->page($p["page"]);
        $bargains->orderByExpr("status not in (0, 200, 500)");
        $bargains->asc("callTime", true);

        // Учитываем поиск
        $bargains->search($p["search"]);

        if($p["user"]) {
            $bargains->eq("userId", $p["user"]);
        }

        if($p["status"] != "*") {
            $bargains->eq("status", $p["status"]);
        }

        $ret = app()->tm("/heapit/bargain-list/content/ajax")
            ->param("bargains", $bargains)
            ->getContentForAjax();

        return array(
            "html" => $ret,
            "total" => $bargains->pages(),
        );

    }
    
}
