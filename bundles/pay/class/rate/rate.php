<?

class pay_rate extends reflex {

    

public static function model() {return array (
  'name' => 'pay_rate',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => 'xo9uvkr15yq9fdztzac2hv2lg27vxi',
    ),
    1 => 
    array (
      'name' => 'from',
      'type' => 'rtwaho8esx49ijy9rtc1',
      'editable' => '1',
      'id' => 'p5mlsepnl4z3evgswo6dpqpao82g4c',
      'label' => 'Из',
      'indexEnabled' => 1,
    ),
    2 => 
    array (
      'name' => 'to',
      'type' => 'rtwaho8esx49ijy9rtc1',
      'editable' => '1',
      'id' => 'ua0pwphnrxac65e1ehui4k3n5npxsj',
      'label' => 'В',
      'indexEnabled' => 1,
    ),
    3 => 
    array (
      'name' => 'rate',
      'type' => 'yvbj-cgin-m90o-cez7-mv2j',
      'editable' => '1',
      'id' => 'rqrruplzgqdhqdb2o0j2xi3w2zuxcs',
      'label' => 'Курс',
      'indexEnabled' => 1,
    ),
    4 => 
    array (
      'name' => 'updated',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '1',
      'id' => '38w5xs2vav6m5xi073bh6fh1q52ivs',
      'label' => 'Время обновления',
      'indexEnabled' => 1,
    ),
  ),
  'indexes' => 
  array (
  ),
);}

/**
     * Получить курс
     **/
    public static function get($from,$to) {
        return reflex::get(get_class())->eq("from",$from)->eq("to",$to)->one();
    }

    /**
     * Возвращает коллекцию всех курсов
     **/
    public static function all() {
        return reflex::get(get_class())->asc("from")->asc("to",true);
    }

    /**
     * Возвращает значение курса
     **/
    public function rate() {
        return $this->data("rate");
    }

    /**
     * Разделы для каталога
     **/
    public function reflex_root() {
        return array(
            self::all()->param("title","Курсы валют")->param("tab","system"),
        );
    }

    public function reflex_title() {
        return "1 ".$this->field("to")->code()." = ".$this->rate()."&nbsp;".$this->field("from")->code();
    }

    public function setRate($from,$to,$rate) {

        if(!array_key_exists($from,mod_field_currency::$codes))
            return;

        if(!array_key_exists($to,mod_field_currency::$codes))
            return;

        $item = self::get($from,$to);
        if(!$item->exists()) {
            $item = reflex::create(get_class(),array(
                "from" => $from,
                "to" => $to,
                "rate" => $rate,
            ));
        }

        $item->data("rate",$rate);
        $item->data("updated",util::now());

    }

    public function getRate($srcCurrency,$destCurrency) {

        $item = self::get($srcCurrency,$destCurrency);

        if($srcCurrency == $destCurrency) {
            return 1;
        }

        if(!$item->exists()) {
            throw new Exception("Курс валют ".mod::field("currency")->value($srcCurrency)->code()." -> ".mod::field("currency")->value($destCurrency)->code()." не найден");
        }

        return $item->rate();
    }

    public function convert($srcAmount, $srcCurrency,$destCurrency) {
        return $srcAmount / self::getRate($srcCurrency,$destCurrency);
    }

}
