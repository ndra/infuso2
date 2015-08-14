<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 11.08.2015
 * Time: 14:22
 */

namespace Infuso\Pay\Model;
use Infuso\Core;
use Infuso\Core\Model\Currency as Currency;

class Rate extends \Infuso\ActiveRecord\Record
{
    public function getRate($srcCurrency,$destCurrency) {

        $item = self::get($srcCurrency,$destCurrency);

        if($srcCurrency == $destCurrency) {
            return 1;
        }

        if(!$item->exists()) {
            throw new \Exception("Курс валют ".mod::field("currency")->value($srcCurrency)->code()." -> ".mod::field("currency")->value($destCurrency)->code()." не найден");
        }

        return $item->rate();
    }

    public function convert($srcAmount, $srcCurrency,$destCurrency) {
        return $srcAmount / self::getRate($srcCurrency,$destCurrency);
    }


    public function setRate($from,$to,$rate) {

        if(!array_key_exists($from,Currency::$codes))
            return;

        if(!array_key_exists($to,Currency::$codes))
            return;

        $item = self::get($from,$to);
        if(!$item->exists()) {
            $item = service("ar")
                ->collection(get_class())->create(get_class(),array(
                "from" => $from,
                "to" => $to,
                "rate" => $rate,
            ));
        }

        $item->data("rate",$rate);
        $item->data("updated",util::now());

    }


    public function recordTitle() {
        return "1 ".$this->field("to")->code()." = ".$this->rate()."&nbsp;".$this->field("from")->code();
    }

    /**
     * Возвращает значение курса
     **/
    public function rate() {
        return $this->data("rate");
    }

    /**
    * Получить курс
    **/
    public static function get($from,$to) {
        return service("ar")
            ->collection(get_class())->eq("from",$from)->eq("to",$to)->one();
    }

    /**
     * Возвращает коллекцию всех курсов
     **/
    public static function all() {
        return service("ar")
            ->collection(get_class())->asc("from")->asc("to",true);
    }

    public static function model()
    {
        return array (
            'name' => get_class(),
            'fields' =>
                array (

                        array (
                            'name' => 'id',
                            'type' => 'jft7-kef8-ccd6-kg85-iueh',
                            'editable' => '1',
                        ),

                        array (
                            'name' => 'from',
                            'type' => 'rtwaho8esx49ijy9rtc1',
                            'editable' => '1',
                            'label' => 'Из',
                            'indexEnabled' => 1,
                        ),

                        array (
                            'name' => 'to',
                            'type' => 'rtwaho8esx49ijy9rtc1',
                            'editable' => '1',
                            'label' => 'В',
                            'indexEnabled' => 1,
                        ),

                        array (
                            'name' => 'rate',
                            'type' => 'yvbj-cgin-m90o-cez7-mv2j',
                            'editable' => '1',
                            'label' => 'Курс',
                            'indexEnabled' => 1,
                        ),

                        array (
                            'name' => 'updated',
                            'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                            'editable' => '1',
                            'label' => 'Время обновления',
                            'indexEnabled' => 1,
                        ),
                ),

        );
    }
}