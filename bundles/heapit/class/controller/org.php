<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Org extends Base {

    public function index() {
        app()->tm()->exec("/heapit/org-list");
    }

    public function index_test() {
        $action = Core\Action::get("infuso\\heapit\\controller\\org", "index");
        echo service("route")->actionToUrlNocache($action);
    }

    public function index_add() {
        app()->tm()->exec("/heapit/org-new");
    }

    /**
     * Создает контрагента
     **/
    public static function post_new($p) {

        if(!$p["data"]["title"]) {
            app()->msg("Название не указано",1);
            return false;
        }

        $org = service("ar")->create("Infuso\\Heapit\\Model\\Org", $p["data"]);
        return $org->url();

    }
    

    // Вносит изменения в карточку
    public static function post_save($p) {

        if(!$p["data"]["title"]) {
            log::msg("Название не указано",1);
            return false;
        }

        $org = \Infuso\Heapit\Model\Org::get($p["orgId"]);
        $save = array(
            "title",
            "phone",
            "email",
            "url",
            "person",
            "icq",
            "skype",
            "referral"
        );

        foreach($save as $key) {
            $org->data($key,$p["data"][$key]);
        }
        
        app()->msg("Сохранено");
    }

    /**
     * Возвращает html-код списка контрагентов
     **/
    public function post_search($p) {

        $items = \Infuso\Heapit\Model\Org::all();
        $items->page($p["page"]);

        // Учитываем поиск по имени
        if($search = trim($p["search"])) {
            $items->search($p["search"]);
        }

        $items->eq("deleted",0);
        $items->desc("opened");

        $html = app()->tm("/heapit/org-list/org-list/ajax")
            ->param("orgs", $items)
            ->getContentForAjax();
        
        return array(
            "html" => $html,
            "count" => $items->pages(),
        );
        
    }

}
