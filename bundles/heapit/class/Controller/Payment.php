<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Payment extends Core\Controller {

    public static function indexTest() {
        return true;
    }
    
    public static function postTest() {
        return true;
    }
    
    public function index() {
        $this->app()->tmp()->exec("/heapit/payment-list");
    }
    
    public function index_add() {
        $this->app()->tmp()->exec("/heapit/payment-new");
    }
    
    /**
     * Создает сделки
     **/
    public static function post_new($p) {
        if(!$p["data"]["orgID"]) {
            Core\Mod::msg("id контранета не указано",1);
            return false;
        }
        
        $bargain = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Payment", $p["data"]);
        Core\Mod::msg($bargain->url());
    }
    
}
