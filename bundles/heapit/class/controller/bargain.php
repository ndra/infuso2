<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use \Infuso\Heapit\Model;

class Bargain extends Base {

    public function index() {
        $this->app()->tmp()->exec("/heapit/bargain-list");
    }
    
    public function index_add() {
        $this->app()->tmp()->exec("/heapit/bargain-new");
    }
    
    /**
     * Создает сделки
     **/
    public static function post_new($p) {
        $bargain = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Bargain", $p["data"]);
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
     * Возвращает html-код списка сделок
     **/
    public function post_search($p) {

        $bargains = \Infuso\Heapit\Model\Bargain::all();
        $bargains->page($p["page"]);
        $bargains->asc("statusPriority");
        $bargains->asc("callTime", true);

        // Учитываем поиск
        $bargains->search($p["search"]);

        if($p["user"]) {
            $bargains->eq("userId", $p["user"]);
        }

        if($p["status"] != "*") {
            $bargains->eq("status", $p["status"]);
        }

        $ret = \tmp::get("/heapit/bargain-list/content/ajax")
            ->param("bargains", $bargains)
            ->getContentForAjax();

        return array(
            "html" => $ret,
            "total" => $bargains->pages(),
        );

    }
    
}
