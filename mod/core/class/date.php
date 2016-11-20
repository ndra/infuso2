<?

namespace Infuso\Core;
use \Infuso\Core;

class Date extends Core\Component {

    /**
     * Метка времени
     **/
    //private $time = null;

    private $timeEnabled = true;
    
    private $datetime;

    /**
     * Конструктор
     * @todo дорефакторить, убрать старые функции типа mktime
     **/
    public function __construct($time, $m = 1, $d = 1, $h = 0, $min = 0, $s = 0) {

        $this->addBehaviour("Infuso\\Core\\Date\\Ru");
        
        $this->datetime = new \DateTime();

        switch(func_num_args()) {
            case 1:
            
                // Числа интерпретируются как timestamp

                if(intval($time)."" == $time) {
                    $this->datetime->setTimestamp($time);

                // В противном случае попробуем распарсить строку

                } else {
                    $this->datetime = new \DateTime($time);
                }

                break;
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $this->datetime->setTimestamp(mktime($h, $min, $s, $m, $d, $time));
                break;
        }

    }
    
    /**
     * Возвращает текущую дату
     **/
    public static function now() {
        return self::get(@date("Y-m-d H:i:s"));
    }

    /**
     * Алиас к конструктору
     **/
    public static function get() {
        $reflector = new \ReflectionClass(get_class());
        return $reflector->newInstanceArgs(func_get_args());
    }

    /**
     * Объект преобразуется в строку c mysql-представлением даты, например 2038-01-19 03:14:07
     */
    public function __toString() {
        return $this->standart();
    }
    
    /**
     * Возвращает / устанавливает таймзону
     **/
    public function timezone($zone = null) {
        if(func_num_args() == 0) {
            return $this->datetime->getTimezone()->getName();
        } elseif(func_num_args() == 1) {
            $this->datetime->setTimezone(new \DateTimeZone($zone));
            return $this;
        }
        throw new \Exception();
    }
    
    /**
     * Возвращает массив таймзон
     **/
    public static function timezones() {
        return \DateTimeZone::listIdentifiers();
    }
    
    /**
     * Создает копию объекта
     **/
    public function copy() {
        return clone $this;
    }
    
    public function __clone() {
        $this->datetime = clone $this->datetime;
    }

    /**
     * Алиас к функции text
     **/
    public final function txt() {
        return $this->text();
    }

    /**
     * Оставляет только дату
     * Убираем часы, минуты и секунды из таймстэмпа
     **/
    public function date() {
        $this->timeEnabled = false;
        $this->hours(0);
        $this->minutes(0);
        $this->seconds(0);
        return $this;
    }
    
    /**
     * Возвращает время в формате ЧЧ:ММ
     **/
    public function time() {
        return str_pad($this->hours(), 2, 0, STR_PAD_LEFT).":".str_pad($this->minutes(), 2, 0, STR_PAD_LEFT);
    }
    
    /**
     * Возвращет метку времени linux
     **/
    public function stamp() {
        return $this->datetime->getTimestamp();
    }

    /**
     * Возвращает true если дата-время и false если просто дата
     **/
    public function timeEnabled() {
        return $this->timeEnabled;
    }
    
    /**
     * Прибавляет к дате заданное количество секунд (переносит дату в будущее)
     * Если аргумент отрицательный, переносит дату на заданное количество секунд в прошлое
     **/
    public function shift($s) {
        $this->datetime->setTimestamp($this->datetime->getTimestamp() + $s);
        return $this;
    }

    /**
     * Увеличивает / уменьшает дату на заданное количество дней
     **/
    public function shiftDay($day) {
        $day = round($day);
        $this->datetime->modify("+{$day} day");
        return $this;
    }

    /**
     * Увеличивает / уменьшает дату на заданное количество месяцев
     **/
    public function shiftMonth($month) {
        $month = round($month);
        $this->datetime->modify("+{$month} month");
        return $this;
    }

    /**
     * Увеличивает / уменьшает дату на заданное количество лет
     **/
    public function shiftYear($year) {
        $year = round($year);
        $this->datetime->modify("+{$year} year");
        return $this;
    }

    /**
     * Возвращает дату / время в формате mysql
     **/
    public function standart() {
        return $this->format($this->timeEnabled() ? "Y-m-d H:i:s" : "Y-m-d");
    }
    
    public function format($format) {
        return $this->datetime->format($format);
    }

    /**
    * Возвращает год, четыре цифры
    **/
    public function year($year = null) {

        if(func_num_args() == 0) {
            return $this->format("Y");
        } elseif(func_num_args() == 1) {
            $this->datetime->setDate($year, $this->month(), $this->day());
            return $this;
        }
        throw new \Exception();    
    }
    
    /**
     * Алиас к years()
     **/    
    public function years() {
        return call_user_func_array(array($this, "year"), func_get_args());
    }

    /**
    * Возвращает / мееняет месяц
    **/
    public function month($month = null) {

        if(func_num_args() == 0) {
            return $this->format("m");
        } elseif(func_num_args() == 1) {
            $this->datetime->setDate($this->year(), $month, $this->day());
            return $this;
        }
        throw new \Exception();    
    }
    
    /**
     * Алиас к month()
     **/    
    public function months() {
        return call_user_func_array(array($this, "month"), func_get_args());
    }

    /**
    * Возвращает / изменяет день
    **/
    public function day($day = null) {

        if(func_num_args() == 0) {
            return $this->format("j");
        } elseif(func_num_args() == 1) {
            $this->datetime->setDate($this->year(), $this->month(), $day);
            return $this;
        }
        throw new \Exception();    
    }
    
    /**
     * Алиас к day()
     **/    
    public function days() {
        return call_user_func_array(array($this, "day"), func_get_args());
    }
    
    /**
     * Возвращает номер коммерческого дня недели
     * 1 - Понедельник
     * 2 - Вторник
     * ...
     * 7 - Воскресенье
     **/
    public function commercialWeekDay($day = null) {
    
        if(func_num_args() == 0 ) {
        
            $map = array(
                0 => 7,
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
            );
        
            return $map[$this->format("w")];
        }
        
        if(func_num_args() == 1) {
            $wday = $this->commercialWeekDay();
            $this->shiftDay( 1 - $wday );
            $this->shiftDay( $day - 1 );
            return $this;
        }
        
    }
    
    /**
     * Возвращает / изменяет минуты даты
     **/
    public function seconds($seconds = null) {

        if(func_num_args() == 0) {
            return $this->format("s");
        } elseif(func_num_args() == 1) {
            $this->datetime->setTime($this->hours(), $this->minutes(), $seconds);
            return $this;
        }
        throw new \Exception();    
    }

    /**
     * Алиас к seconds()
     **/    
    public function second() {
        return call_user_func_array(array($this, "seconds"), func_get_args());
    }

    /**
     * Возвращает / изменяет минуты даты
     **/
    public function minutes($minutes = null) {

        if(func_num_args() == 0) {
            return $this->format("i");
        } elseif(func_num_args() == 1) {
            $this->datetime->setTime($this->hours(), $minutes, $this->seconds());
            return $this;
        }
        throw new \Exception();    
    }

    /**
     * Алиас к minutes()
     **/    
    public function minute() {
        return call_user_func_array(array($this, "minutes"), func_get_args());
    }

    /**
     * Возвращает / изменяет часы даты
     **/
    public function hours($hours = null) {

        if(func_num_args() == 0) {
            return $this->format("H");
        } elseif(func_num_args() == 1) {
            $this->datetime->setTime($hours, $this->minutes(), $this->seconds());
            return $this;
        }
        throw new \Exception();
    }
    
    /**
     * Алиас к hours()
     **/
    public function hour() {
        return call_user_func_array(array($this, "hours"), func_get_args());
    }

}
