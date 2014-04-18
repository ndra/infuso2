<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Payment extends Base {

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
        
        $payment = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Payment", $p["data"]);
        return $payment->url();
    }
    
    // Вносит изменения в карточку
    public static function post_save($p) {

        if(!$p["data"]["orgID"]) {
            Core\Mod::msg("id контранета не указано",1);
            return false;
        }
        
        if($p["paymentId"]){
            Core\Mod::msg("id платежа не указано",1);
            return false;    
        }

        $payment = \Infuso\Heapit\Model\Payment::get($p["paymentId"]);
        $payment->setData($p["data"]);
        
        Core\Mod::msg("Сохранено");
    }
    
}
