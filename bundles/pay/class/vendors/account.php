<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 13.08.2015
 * Time: 15:18
 */

namespace Infuso\Pay\Vendor;
use Infuso\Pay\Model\Invoice;
use Infuso\User\Model\User;

class Account extends Vendor
{
    /**
     * Сделать видимость класса для браузеров (pay_vendors наследует mod_controller)
     **/
    public static function indexTest() {
        return true;
    }

    /**
     * Сделать видимость POST функции
     **/
    public static function postTest() {
        return true;
    }

    /**
     * Список счетов у текущего пользователя
     **/
    public function index_history() {
        $user = User::active();
        $items = $user->payAccountOperationLog();
        app()->tm("/pay/account/history")->param("items", $items)->exec();
    }

    /**
     * Вывести форму подтверждения оплаты инвойса
     **/
    public function index_approveOrder($p) {

        $invoice = Invoice::get(intval($p["id"]));

        $invoice->driver("account")->checkInvoicePayAvailable();

        app()->tm("/pay/account/payConfirmation")->param("invoice",$invoice)->exec();
    }

    /**
     * Возвращает ссылку для оплаты инвойса
     **/
    public function payUrl() {
        $url = "/pay_vendors_account/approveOrder?id=".$this->invoice()->id();
        return $url;
    }

    /**
     * Перенаправление на страницу оплаты инвойса в случае подтверждения его дальнейшей оплаты
     **/
    public static function post_payAccept($p) {

        $driverObject = Invoice::get(intval($p["invoiceId"]))->driver("account");

        // Проверить доступность оплаты инвойса
        if ($driverObject->checkInvoicePayAvailable()) {
            // Оплатить инвойс и выбросить событие оплаты заказа
            $driverObject->payInvoice();
            header("location: {$driverObject->invoice()->url()}");
            die();
        }
    }

    /**
     * Перенаправление на страницу отмены оплаты инвойса в случае отказа от его дальнейшей оплаты
     **/
    public static function post_payDecline($p) {

        $invoice = Invoice::get($p["invoiceId"]*1);

        if(!$invoice->my()) {
            throw new \Exception("Попытка отменить чужой инвойс");
        }

        if($invoice->paid()) {
            throw new \Exception("Попытка отменить инвойс который оплачен");
        }

        $invoice->setErrorText("Отмена оплаты клиентом");
        header("Location: {$invoice->url()}");
        die();

    }

    /**
     * Проверить доступность оплаты инвойса
     **/
    public function checkInvoicePayAvailable() {

        $currentUser = user::active();

        if(!$this->invoice()->user()->exists()) {
            $this->alertCantPay("Попытка оплаты неавторизованным пользователем");
        }

        // Проверка соответствия текущего пользователя и пользователя, сделавшего инвойс
        if ($currentUser->id() != $this->invoice()->data("userId")) {
            $this->alertCantPay("Попытка оплаты чужого счета");
        }

        // Проверка совпадения валют счета и личного кабинета
        if ($currentUser->accountCurrency() != $this->invoice()->currency()) {
            $this->alertCantPay("Несовпадение валют счета и личного кабинета :".$this->invoice()->currency()." и ".$currentUser->accountCurrency());
        }

        // Проверка наличия денег на внутреннем счете пользователя для оплаты инвойса
        if ($currentUser->data("userCash") < $this->invoice()->sum()) {
            $this->alertCantPay("На личном счете недостаточно средств для оплаты");
        }

        // Проверка статуса оплаченности инвойса
        if ($this->invoice()->paid() != 0) {
            $this->alertCantPay("Счет уже оплачен.");
        }

        // Проверка актуальности инвойса - полчаса
        $invoiceLifeTime = util::now()->stamp() - $this->invoice()->pdata("date")->stamp();
        if ($invoiceLifeTime > 1800) {
            $this->alertCantPay("Счет устарел.");
        }

        // Проверка соответствия текущего инвойса последенему созданному инвойсу
        $lastInvoiceId = pay_invoice::all()->eq("userId", $currentUser->id())->desc("id")->one()->id();
        if($this->invoice()->num() != $lastInvoiceId) {
            $this->alertCantPay("Счет устарел или его не существует.");
        }

        return true;
    }

    /**
     * Показать сообщение об ошибке и остановить работу
     **/
    public function alertCantPay($msg) {
        $this->invoice()->setErrorText($msg);
        header("location:{$this->invoice()->url()}");
    }

    /**
     * Оплатить инвойс и снять со счета пользователя сумму
     **/
    public function payInvoice() {

        $currentUser = user::active();

        // Установить у инвойса статус "Оплачен"
        $result = $this->invoice()->incoming(array(
            "sum" => $this->invoice()->sum(),
            "driver" => "Личный счет",
        ));

        if ($result === true) {
            // Списать сумму инвойса со счета пользователя
            $currentUser->withdrawFunds($this->invoice()->sum(), $this->invoice()->details()); //pay_behaviour_user
        }
    }
}