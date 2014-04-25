<?

namespace Infuso\Util\Date;
use \Infuso\Core;

class Ru extends Core\Behaviour {

    /**
     * Возвращает текстовое значение времни
     * Например, 12 февраля 2012 г. 12:35
     **/
    public function text() {


        $ret = "";
        $date = @getdate($this->stamp());

        $d = clone $this;



        if($d->date()->num() == \util::now()->date()->num()) {
            $ret.= "сегодня ";
        } elseif($d->date()->num() == \util::now()->shiftDay(-1)->date()->num()) {
            $ret.= "вчера ";
        } else {

            $months = array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
            $ret.= $date["mday"]." ".$months[$date["mon"]-1];
            $ret.= " $date[year] г. ";
        }

        // Добавляем время
        if($this->timeEnabled()) {
            $ret.= $date["hours"].":".str_pad($date["minutes"],2,0,STR_PAD_LEFT);
        }

        return $ret;
    }

    /**
     * Возвращает числовое значение времени, например 30.12.20012
     **/
    public function num() {
        return @date("d.m.Y H:i",$this->stamp());
    }

    /**
     * Возвращает строку с описанием времени относительно текущего момента
     * Примеры возвращаемых значений: "Толко что", "2 мин. назад", ""
     **/
    public function left() {

        $now = $this->timeEnabled() ? \Infuso\Util\Date::now() :\Infuso\Util\Date::now()->date();
        $d = $this->stamp() - $now->stamp();
        return $this->timeEnabled() ? $this->duration($d) : $this->durationDate($d);
    }

    /**
    * Возвращает месяц в текстовом виде
    **/
    public function monthTxt() {
        $m = array(
            "январь",
            "февраль",
            "март",
            "апрель",
            "май",
            "июнь",
            "июль",
            "август",
            "сентябрь",
            "октябрь",
            "ноябрь",
            "декабрь",
        );
        return $m[$this->month() - 1];
    }

    public function duration($di) {

        $d = abs($di);

        $minutes = floor($d/60);
        $hours = floor($minutes/60);
        $rminutes = $minutes % 60;
        $rhours = $hours % 24;
        $days = floor($hours/24);

        $ret = array();

        if($days > 0) {
            $ret[] = $days."&nbsp;д.";
        }

        if($rhours > 0 && $hours < 24 * 2) {
            $ret[] = $rhours."&nbsp;ч.";
        }

        if($rminutes > 0 && $minutes < 60 * 3) {
            $ret[] = $rminutes."&nbsp;мин.";
        }

        if($minutes == 0) {
            $ret = array("только что");
        }

        $ret = implode(" ",$ret);

        if($minutes > 0) {
            $ret = $di < 0 ? "$ret назад" : "через $ret";
        }

        return $ret;
    }

    public function durationDate($d) {

        $days = floor($d/3600/24);

        switch($days) {

            case 2:
                return "послезавтра";
            case 1:
                return "завтра";
            case 0:
                return "сегодня";
            case -1:
                return "вчера";
            case -2:
                return "позавчера";

        }

        $ret = abs($days)." д.";
        $ret = $days < 0 ? "$ret назад" : "через $ret";

        return $ret;

    }

}
