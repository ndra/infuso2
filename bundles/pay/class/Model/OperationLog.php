<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 13.08.2015
 * Time: 15:28
 */

namespace Infuso\Pay\Model;
use Infuso\Core;

class OperationLog extends \Infuso\ActiveRecord\Record
{

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
     * Взять или установить значение даты операции
     **/
    public function date($date = null) {
        if ($date == null) {
            return $this->data("date"); }
        else {
            $this->data("date", $date);
            return $this; }
    }

    /**
     * Возвращает сумму транзакции
     **/
    public function amount() {
        return $this->data("amount");
    }

    /**
     * Взять или установить значения комментария к совершенной операции
     **/
    public function comment($comment = null) {
        if ($comment == null) {
            return $this->data("comment");
        } else {
            $this->data("comment", $comment);
            return $this;
        }
    }

    /**
     * Отобразить форматированные заголовки в списке подменю "Операции"
     **/
    public function recordTitle() {

        $ret = $type." ".$this->amount()." ".$this->currency()." от ".$this->date()." ".$this->comment();

        if ($this->amount() >= 0) {
            $ret = "<span style='color:green;'>$ret</span>";
        } else {
            $ret = "<span style='color:red;'>$ret</span>";
        }

        return $ret;

    }

    public function user() {
        return $this->pdata("userId");
    }

    public function recordParent() {
        return $this->user();
    }

    /**
     * Заполнить данные по умолчанию только что созданого элемента
     **/
    public function beforeCreate() {
        $this->date(\Infuso\Util\Util::now());
    }

    public static function model()
    {
        return array (
            'name' => 'pay_operationLog',
            'fields' =>
                array (

                        array (
                            'name' => 'id',
                            'type' => 'jft7-kef8-ccd6-kg85-iueh',
                            'editable' => '1',
                        ),

                        array (
                            'name' => 'date',
                            'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                            'editable' => 2,
                            'indexEnabled' => 1,
                        ),

                        array (
                            'name' => 'userId',
                            'type' => 'pg03-cv07-y16t-kli7-fe6x',
                            'editable' => 2,
                            'label' => 'Пользователь',
                            'indexEnabled' => 1,
                            'class' => 'user',
                        ),

                        array (
                            'name' => 'amount',
                            'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                            'editable' => 2,
                            'group' => 'Сумма',
                            'indexEnabled' => 1,
                        ),

                        array (
                            'name' => 'comment',
                            'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                            'editable' => 2,
                            'label' => 'Комментарий',
                            'indexEnabled' => 1,
                        ),
                ),
            'indexes' =>
                array (
                ),
        );
    }
}