<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use \Infuso\Heapit\Model;

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
            $data["income"] = $amount;
            $data["expenditure"] = 0;
        } else {
            $data["income"] = 0;
            $data["expenditure"] = $amount;
        }

        $data["description"] = $p["data"]["description"];
        $data["orgId"] = $p["data"]["orgId"];
        $data["date"] = $p["data"]["date"];
        $data["group"] = $p["data"]["group"];

        $payment = Core\Mod::service("ar")->create("Infuso\\Heapit\\Model\\Payment", $data);
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
        $payment->data("date", $p["data"]["date"]);
        $payment->data("group", $p["data"]["group"]);

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
    
    
    /**
     * Возвращает html-код списка платежей
     **/
    public function post_search($p) {

        $payments = \Infuso\Heapit\Model\Payment::all();
        $payments->page($p["page"]);
        $payments->desc("date");
        //$bargains->asc("lastComment", true);

        // Учитываем поиск
        $payments->search($p["search"]);

        $ret = \tmp::get("/heapit/payment-list/list/ajax")
            ->param("payments", $payments)
            ->getContentForAjax();

        return array(
            "html" => $ret,
            "total" => $payments->pages(),
        );

    }
    
}
