<?php
/**
 * Драйвер системы оплаты Robokassa
 * http://robokassa.ru
 *
 * @version 0.4
 * @package pay
 * @author Petr.Grishin <petr.grishin@grishini.ru>
 * updated by Alexey.Dvourechesnky <alexey@ndra.ru>
 **/

namespace Infuso\Pay\Vendor;
use Infuso\Pay\Model\Invoice;

class Robokassa extends Vendor
{
    /**
     * Защитный ключ
     **/
    private static $key = NULL;
    private static $login = NULL;
    private static $passSecure1 = NULL;
    private static $passSecure2 = NULL;

    /**
     * Валюта зачисляемых денежных средств: только RUR (код 643)
     **/
    private static $currency = 643;

    public static function confDescription() {
        return array(
            "components" => array(
                get_class() => array(
                    "params" => array(
                        "key" => "Робокасса: Cекретный ключ",
                        "login" => "Робокасса: Логин магазина(шоп-id)",
                        "secure-1" => "Робокасса: Подпись 1",
                        "secure-2" => "Робокасса: Подпись 2",
                    ),
                ),
            ),
        );
    }

    /**
     * Заполняем данные по умолчанию для драйвера Robokassa
     *
     * @return void
     **/
    private function loadConf() {
        if (NULL == self::$key = $this->param("key"))
            throw new \Exception("Робокасса: не задан секретный ключ");
        if (NULL == self::$login = $this->param("login"))
            throw new \Exception("Робокасса: не задан логин");
        if (NULL == self::$passSecure1 = $this->param("secure-1"))
            throw new \Exception("Робокасса: не задана подпись 1");
        if (NULL == self::$passSecure2 = $this->param("secure-2"))
            throw new \Exception("Робокасса: не задана подпись 2");
    }

    /**
     * Зачисление денежных средств для драйвера Robokassa
     *
     * @return void
     * @todo Изменить вызов метода incoming у инвойса
     **/
    public function index_result($p = NULL) {

        self::loadConf();

        if ($p["key"] != self::$key)
            throw new \Exception("Робокасса: неверный защитный ключ");

        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);
        $my_crc = strtoupper(md5("$out_summ:$inv_id:".self::$passSecure2));

        if (strtoupper($my_crc) != strtoupper($crc))
            throw new \Exception("Неверная подпись CRC");

        //Загружаем счет
        $invoice = Invoice::get((integer)$inv_id);

        if (!$invoice->exists())
            throw new \Exception("Не нашли счет с указанным номером");

        if ($invoice->paid()) {
            $invoice->plugin("log")->log("Не доступен для оплаты, т.к. счет уже был оплачен ранее");
            throw new \Exception("Robokassa: Не доступен для оплаты, т.к. счет уже был оплачен ранее");
        }

        if ($invoice->data("currency") != self::$currency) {
            $invoice->plugin("log")->log("Счет выставлен в другой валюте, код " . $invoice->data("currency"));
            throw new \Exception("Счет выставлен в другой валюте, код " . $invoice->data("currency"));
        }

        //Зачисляем средства
        $invoice->incoming(array(
                "sum" => (string)$out_summ,
                "driver" => "Robokassa")
        );

    }

    /**
     * Выполнено зачисление средств
     *
     * @return void
     * @todo Нужно переписать методы index_success и index_fail что бы они возвращали редирект на страницу счета.
     **/
    public function index_success($p = NULL) {

        self::loadConf();

        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);

        $my_crc = strtoupper(md5("$out_summ:$inv_id:" . self::$passSecure1));

        if (strtoupper($my_crc) != strtoupper($crc))
            throw new \Exception("Неверная подпись CRC");

        // Загружаем счет
        $invoice = Invoice::get((integer)$inv_id);

        header("location: {$invoice->url()}");
        die();
    }

    /**
     * Ошибка при зачисление денежных средств
     *
     * @return void
     * @todo Нужно переписать методы index_success и index_fail что бы они возвращали редирект на страницу счета.
     **/
    public function index_fail($p = NULL) {
        self::loadConf();

        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);

        $my_crc = strtoupper(md5("$out_summ:$inv_id:" . self::$passSecure1));

        if (strtoupper($my_crc) != strtoupper($crc))
            throw new \Exception("Неверная подпись CRC");

        // Загружаем счет
        $invoice = Invoice::get((integer)$inv_id);

        header("location: {$invoice->url()}");
        die();
    }

    /**
     * Сгенерировать адрес платежной системы для оплаты
     *
     * @return string
     **/
    public function payUrl() {

        self::loadConf();

        $crc = md5(self::$login.":".$this->invoice()->sum().":".$this->invoice()->id().":".self::$passSecure1);

        $url  = "https://merchant.roboxchange.com/Index.aspx?";

        $parameters = array(
            'MrchLogin' => self::$login,
            'OutSum' => $this->invoice()->sum(),
            'InvId' => $this->invoice()->id(),
            'Desc' => mb_substr($this->invoice()->details(), 0, 99),
            'SignatureValue' => $crc,
        );

        $url .= http_build_query($parameters);

        return $url;
    }
}