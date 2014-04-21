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
    
    public static function post_save($p) {
        $bargain = Model\Bargain::get($p["bargainId"]);
        $bargain->setData($p["data"]);
        Core\Mod::msg("Сохранено");
    }
    
    /**
     * Возвращает html-код списка сделок
     **/
    public function post_search($p) {

        $bargains = \Infuso\Heapit\Model\Bargain::all();
        $bargains->page($p["page"]);
		$bargains->asc("status");
		$bargains->asc("lastComment", true);

        // Учитываем поиск по имени
        if($search = trim($p["search"])) {
            $bargains->like("title","$search");
        }

        $ret = \tmp::get("/heapit/bargain-list/content/ajax")
            ->param("bargains", $bargains)
            ->getContentForAjax();

        return $ret;

    }
    
}
