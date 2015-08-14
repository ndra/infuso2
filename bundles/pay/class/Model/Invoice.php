<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 07.08.2015
 * Time: 16:10
 */

namespace Infuso\Pay\Model;
use Infuso\Core;
use Infuso\User\Model\User as User;

class Invoice extends \Infuso\ActiveRecord\Record implements \Infuso\Core\Handler
{
    /**
     * Статус счета Ожидает оплаты
     **/
    const STATUS_DEFAULT = 0;

    /**
     * Статус счета Отменен
     **/
    const STATUS_CANCELED = -1;

    /**
     * Статус счета Оплачен
     **/
    const STATUS_PAID = 1;

    /**
     * Статус счета Требует проверки статуса
     **/
    const STATUS_CHECK = 10;

    /**
     * Видимость класса для http запросов
     *
     * @return boolean
     **/
    public static function indexTest() {
        return true;
    }

    /**
     * Выводит информацию о счете
     **/
    public function index_item($p) {

        $invoice = self::get((integer)$p["id"]);

        if(!$invoice->my()) {
            mod_cmd::error(404);
            die();
        }

        app()->tm("/pay/invoice")->param("invoice", $invoice)->exec();
    }

    /**
     * Возвращает true/false в зависимости от того, может ли пользователь просматривать
     * этот счет
     **/
    public function my() {

        $user = user::active();

        // Если в счете записано ID активного пользователя, то может
        if($user->exists()) {
            if($user->id() == $this->user()->id())
                return true;
        }

        // Если в сессии записано ID этого инвойса, то может
        @session_start();
        if(in_array($this->id(),$_SESSION["twer38ebxm96xm1roya0"])) {
            return true;
        }

        // Не может
        return false;

    }

    /**
     * Список всех счетов
     *
     * @return \Infuso\ActiveRecord\Record
     **/
    public static function all() {
        return service("ar")
            ->collection(get_class())->desc("date");
    }

    /**
     * Получить счет
     *
     **/

    public static function get($id = 0) {
        if ($id <= 0 || !is_int($id))
            throw new \Exception("Задан невалидный номер счета: ".var_export($id,1));

        return service("ar")->get(get_class(), $id);
    }

    /**
     * Заполняем данные по умолчанию только что созданого элемента
     *
     **/
    public function beforeCreate() {

        if ($this->data("sum") <= 0) {
            throw new \Exception("Задана невалидная сумма счета, сумма <= 0");
        }

        // Дата создания счета
        $this->data("date", util::now());

        // Статус счета по умолчанию
        $this->status(self::STATUS_DEFAULT);


        // Без пользователя тоже можно создавать инвойсы
        $this->data("userId", user::active()->id());
    }

    /**
     * Возвращает название валюты
     **/
    public function currencyName() {
        return $this->field("currency")->code();
    }

    public function recordTitle()
    {
        return "Счет N" . $this->id()
        . " от " . $this->pdata("date")->txt()
        . " на ".$this->sum()
        . " ".$this->currencyName()
        . ($this->paid() ? " — <span style='color:green;'>оплачен</span>" : " — <span style='color:red;'>ожидает оплаты</span>");
    }

    /**
     * Получить драйвер платежной системы (фабрика классов)
     *
     **/
    public function driver($driver = NULL)
    {
        if ($this->paid() == true) {
            throw new \Exception("Невозможно создать драйвер для уже оплаченого счета");
        }

        if ($driver === NULL) {
            throw new \Exception("Не задан Драйвер платежной системы");
        }

        $class = 'Infuso\\Pay\\Vendor\\' . $driver;

        // Проверка на существование класса драйвера
        if(!service("classmap")->testClass($class)) {
            throw new \Exception("Несуществующий драйвер: " . $class);
        }

        $driverUseonly = $this->data("driverUseonly");
        if ($driverUseonly && $driverUseonly != $driver) {
            throw new \Exception("Текущий счет можно оплатить только драйвером: " . $driverUseonly);
        }

        $obj = new $class($this);

        return $obj;
    }

    /**
     * Получить список доступных драйверов платежных систем
     *
     * @return array
     **/
    public function driverAll() {

        $_drivers = array();
        foreach (service("classmap")->getClassesExtends("Infuso\\Pay\\Vendor\\Vendor") as $class) {
            $_drivers[] = substr($class, 12);
        }

        return $_drivers;
    }

    /**
     * Выводит список всех возможных статусов
     **/
    public function statusAll() {
        return array(
            self::STATUS_DEFAULT    => "Ожидает оплаты",
            self::STATUS_CANCELED   => "Отменен",
            self::STATUS_PAID       => "Оплачен",
            self::STATUS_CHECK      => "Проверка статуса оплаты",
        );
    }

    /**
     * Создать счет (билдер)
     *
     **/
    public static function create($sum = 0, $currency = 643) {

        if ($currency <= 0 || !is_int($currency)) {
            throw new \Exception("Задан невалидный тип валюты: " . gettype($currency));
        }

        $invoice = service("ar")->create(get_class(), array(
            "sum" => $sum,
            "currency" => $currency,
        ));

        $invoice->setCurrentUser();
        return $invoice;
    }

    /**
     * Возвращает валюту счета
     * @return integer
     **/
    public function currency() {
        return $this->data("currency");
    }

    /**
     * Прикрепляет инвойс к текущему пользователю
     **/
    private function setCurrentUser() {

        // Сохраняем ID текущего пользователя в поле
        $this->data("userId", user::active()->id());

        // Сохраняем ID инвойса в сессии
        @session_start();
        $_SESSION["twer38ebxm96xm1roya0"][] = $this->id();

        return $this;
    }

    /**
     * Возвращает владельца счета
     **/
    public function user() {
        return $this->pdata("userId");
    }

    /**
     * Прикрепить или получить счету номер Заказа
     *
     **/
    public function forOrder($n = NULL) {

        if(func_num_args() == 0) {
            return $this->data("for_order");
        }

        if(func_num_args() == 1) {
            if (!$n) throw new \Exception("Не задан номер заказа");
            list($class, $id) = explode(":", $n);
            if(!service("classmap")->testClass($class)) {
                throw new \Exception("Несуществующий класс: " . $class);
            }
            $this->data("for_order", $n);
            return $n;
        }
    }

    public function recordParent() {
        $forOrder = $this->forOrder();
        list($class, $id) = explode(":", $n);
        if(service("classmap")->testClass($class)) {
            return service("ar")->get($class, $id);
        }
    }

    /**
     * Возвращает / устанавливает назначение платежа
     *
     * @return reflex
     **/
    public function details($title = NULL) {

        if(func_num_args() == 0) {
            return $this->data("title");
        }

        if(func_num_args() == 1) {
            $this->data("title", $title);
            return $this;
        }
    }

    /**
     * Возвращает номер счета (равный $this->id())
     *
     * @return integer
     **/
    public function num() {
        return $this->id();
    }

    /**
     * Возвращает сумму счета
     *
     * @return float
     **/
    public function sum() {
        return $this->data("sum");
    }

    /**
     * Возвращает Оплачен ли счет (true - оплачен, false - не оплачен)
     *
     * @return boolean
     **/
    public function paid() {
        return $this->status() == self::STATUS_PAID;
    }

    /**
     * Возвращает текст статуса оплаты
     **/
    public function statusText() {
        $status = $this->status();

        $statusCode = self::statusAll();

        //Совместимость с драйвером локально счета
        $statusCode[self::STATUS_CHECK] = "Ожидает оплаты";

        if (array_key_exists($status, $statusCode)) {
            //Совместимость с драйвером локально счета
            if (!$this->errorText()) {
                return $statusCode[$status];
            } else {
                return "Ошибка оплаты";
            }

        }
        return "Статус не определен";
    }

    public function errorText() {
        return $this->data("errorText");
    }

    public function setErrorText($txt) {
        $this->data("errorText",$txt);
        return $this;
    }

    /**
     * Оплатить счет
     * Возвращает true если сумма оплаты равна сумме счечта
     **/
    public function incoming($params) {

        try {

            if($this->paid()) {
                throw new \Exception("Попытка оплаты уже оплаченного счета");
            }

            $sum = $params["sum"];

            if ($sum <= 0) {
                throw new \Exception("Задана невалидная сумма, сумма <= 0");
            }

            if ($sum >= $this->data("sum")) {

                //Счет оплачен
                $this->status(self::STATUS_PAID);

                $this->data("date_incoming", util::now());
                $this->data("driver", $params["driver"]);

                // Выбрасываем событие оплаты заказа
                app()->fire("pay_success", array(
                    "invoice" => $this,
                ));

                $this->plugin("log")->log("Зачислена сумма {$sum}");

                return true;

            } else {

                throw new \Exception("Входящая сумма {$sum} меньше суммы счета " . $this->data("sum"));

            }

        } catch (\Exception $ex) {
            $this->plugin("log")->log($ex->getMessage());
            throw $ex;
        }

    }

    /**
     * Возвращает строку с адресом, на который надо перебрасывать пользователя
     * в случае успешной или неуспешной оплаты
     **/
    public function redirectURL() {
        return $this->data("redirect");
    }

    /**
     * Устанавливает строку с адресом, на который надо перебрасывать пользователя
     * в случае успешной или неуспешной оплаты
     **/
    public function setRedirectURL($url) {
        $this->data("redirect",$url);
        return $this;
    }

    /**
     * Через какое время проверять статус заказа кроном
     * Например "15 minute", "1 hourly",  "1 day" или "1 week" и т.п.
     **/
    public static function getCheckRefreshTime() {
        return strtotime("-15 minute");
    }

    /**
     * Сколько счетов одновременно проверять статус кроном
     **/
    public static function getCheckRefreshLimit() {
        return 5;
    }

    /**
     * Устанавливаем или получаем статус счета
     **/
    public function status($status = NULL) {

        //Получаем статус
        if(func_num_args() == 0) {
            return $this->data("status");
        }

        //Задаем статус
        if(func_num_args() == 1) {

            if (!array_key_exists($status, self::statusAll()))
                throw new \Exception("Pay: несуществующий статус оплаты с кодом " . $status);

            //Если указан тип Требует прерки, заполняем поле время проверки
            if($status == self::STATUS_CHECK) {
                $this->data("timeCheck", self::getCheckRefreshTime());
            }

            //Установить статус счета
            $this->data("status", $status);

            return $this;
        }
    }

    public static function model()
    {
        return array (
            'name' => get_class(),
            'fields' =>
                array (
                        [
                            'name' => 'id',
                            'type' => 'jft7-kef8-ccd6-kg85-iueh',
                            'editable' => '2',
                            'label' => 'Номер счета',
                        ],
                        [
                            'name' => 'date',
                            'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                            'editable' => '2',
                            'label' => 'Дата',
                        ],
                        [
                            'name' => 'status',
                            'type' => 'fahq-we67-klh3-456t-plbo',
                            'editable' => 2,
                            'label' => 'Статус заказа',
                            'indexEnabled' => 0,
                            'method' => 'statusAll',
                        ],
                        [
                            'name' => 'driver',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => 2,
                            'label' => 'Оплачено через',
                            'indexEnabled' => 0,
                        ],
                        [
                            'name' => 'driverUseonly',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => 2,
                            'indexEnabled' => 0,
                            'label' => 'Счет может быть оплачен только данным драйвером',
                        ],
                        [
                            'name' => 'timeCheck',
                            'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                            'editable' => 2,
                            'label' => 'Время последней проверки статуса оплаты',
                            'indexEnabled' => 0,
                        ],
                        [
                            'name' => 'sum',
                            'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                            'editable' => '2',
                            'label' => 'Сумма счета',
                        ],
                        [
                            'name' => 'currency',
                            'type' => 'rtwaho8esx49ijy9rtc1',
                            'editable' => '2',
                            'label' => 'Валюта счета',
                            'indexEnabled' => 0,
                        ],
                        [
                            'name' => 'date_incoming',
                            'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                            'editable' => '2',
                            'label' => 'Дата оплаты',
                        ],
                        [
                            'name' => 'for_order',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => '2',
                            'label' => 'Номер заказа',
                            'indexEnabled' => 0,
                        ],
                        [
                            'name' => 'title',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => '2',
                            'label' => 'Назначение платежа',
                        ],
                        [
                            'name' => 'userId',
                            'type' => 'pg03-cv07-y16t-kli7-fe6x',
                            'editable' => 2,
                            'label' => 'Пользователь',
                            'indexEnabled' => 1,
                            'class' => 'user',
                        ],
                        [
                            'name' => 'redirect',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => 2,
                            'label' => 'URL возврата после оплаты',
                            'indexEnabled' => 0,
                        ],
                        [
                            'name' => 'errorText',
                            'type' => 'v324-89xr-24nk-0z30-r243',
                            'editable' => '1',
                            'indexEnabled' => 0,
                            'label' => 'Текст ошибки',
                        ],
                ),
        );
    }
}