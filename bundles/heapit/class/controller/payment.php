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

        if(!$p["data"]["orgId"]) {
            Core\Mod::msg("id контранета не указано",1);
            return false;
        }
        
        $payment = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Payment", $p["data"]);
        return $payment->url();
    }
    
    // Вносит изменения в карточку
    public static function post_save($p) {

        if(!$p["data"]["orgId"]) {
            Core\Mod::msg("id контранета не указано",1);
            return false;
        }
        
        if(!$p["paymentId"]){
            Core\Mod::msg("id платежа не указано",1);
            return false;    
        }

        $payment = \Infuso\Heapit\Model\Payment::get($p["paymentId"]);
        $payment->data("description", $p["data"]["description"]);
        $payment->data("orgId", $p["data"]["orgId"]);

        $amount = (int) $p["data"]["amount"];

        if(!$amount) {
            Core\Mod::msg("Не указана сумма");
            return;
        }

        if($amount < 0) {
            Core\Mod::msg("Месье пытается указать отрицательную сумму", 1);
            return;
        }

        if($p["data"]["direction"] === "income") {
            $payment->data("income", $amount);
            $payment->data("expenditure", 0);
        } else {
            $payment->data("income", 0);
            $payment->data("expenditure", $amount);
        }
        
        Core\Mod::msg("Сохранено");
    }
    
}
