<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;
use \Infuso\Heapit\Model;

class Payment extends Base {

    public function index() {
        $this->app()->tm()->exec("/heapit/payment-list");
    }
    
    public function index_add($p) {    
    
        $copy = new Model\Payment();
        $copy->setData(Model\Payment::get($p["copy"])->data());
        $copy->data("date",\util::now());
        if(!$p["copy"]) {
            $copy->data("userId",app()->user()->id());
        }         
        if($p["expend"]) {
            $copy->data("expenditure", 1);
        }
        
        $this->app()->tm()->exec("/heapit/payment-new", array(
            "paymentToCopy" => $copy,
        ));
    }
    
    /**
     * Создает платеж
     **/
    public static function post_new($p) {

        // Ради эксперимента разрешим делать платежи без указания контрагента
        /*if(!$p["data"]["orgId"]) {
            app()->msg("id контранета не указано",1);
            return false;
        }*/

        $amount = (int) $p["data"]["amount"];

        if(!$amount) {
            app()->msg("Не указана сумма");
            return;
        }

        if($amount < 0) {
            app()->msg("Месье пытается указать отрицательную сумму", 1);
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
        $data["status"] = $p["data"]["status"];
        $data["userId"] = $p["data"]["userId"];
        
        $payment = service("ar")->create("Infuso\\Heapit\\Model\\Payment", $data);
        return $payment->url();
    }
    
    // Вносит изменения в карточку
    public static function post_save($p) {

        if(!$p["paymentId"]){
            app()->msg("id платежа не указано",1);
            return false;    
        }

        $payment = \Infuso\Heapit\Model\Payment::get($p["paymentId"]);
        
        if($payment->isLocked()) {
            app()->msg("Изменение платежа заблокировано", 1);
            return;
        }
        
        
        $payment->data("description", $p["data"]["description"]);
        $payment->data("orgId", $p["data"]["orgId"]);
        $payment->data("date", $p["data"]["date"]);
        $payment->data("group", $p["data"]["group"]);
        $payment->data("status", $p["data"]["status"]);    
        $payment->data("userId", $p["data"]["userId"]);    
        $amount = (int) $p["data"]["amount"];

        if(!$amount) {
            app()->msg("Не указана сумма");
            return;
        }

        if($amount < 0) {
            app()->msg("Месье пытается указать отрицательную сумму", 1);
            return;
        }
        
        if($p["data"]["direction"] === "income") {
            $payment->data("income", $amount);
            $payment->data("expenditure", 0);
        } else {
            $payment->data("income", 0);
            $payment->data("expenditure", $amount);
        }
        
        app()->msg("Сохранено");
    }
    
    
    /**
     * Возвращает html-код списка платежей
     **/
    public function post_search($p) {
    
        $payments = \Infuso\Heapit\Model\Payment::all();
        if($p["orgId"]){
            $payments->eq("orgId", $p["orgId"]);
        }
        $payments->page($p["page"]);
        $payments->asc("status");
        $payments->desc("date", true);
        
        if($p["from"]) {
            $payments->geq("date", $p["from"]);
        }
        
        if($p["to"]) {
            $payments->leq("date", $p["to"]);
        }
        
        //$bargains->asc("lastComment", true);
        if(count($p["statuses"])){
            $payments->eq("status", $p["statuses"]);    
        }
        // Учитываем поиск
        $payments->search($p["search"]);

        $ret = app()->tm("/heapit/shared/payment-list/ajax")
            ->param("payments", $payments)
            ->getContentForAjax();

        return array(
            "html" => $ret,
            "total" => $payments->pages(),
        );

    }
    
}
