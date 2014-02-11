<?

/**
 * Запись совершения операции с внутренним счетом пользователя (списание/зачисление)
 **/
class pay_operationLog extends reflex {

    

public static function reflex_table() {return array (
  'name' => 'pay_operationLog',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => '85znwg6qw5it8e2d45r7ma6tk1bjcl',
    ),
    1 => 
    array (
      'name' => 'date',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => 2,
      'id' => '6qm9sop9hj81z7yl2t41it8vsocgs7',
      'indexEnabled' => 1,
    ),
    2 => 
    array (
      'name' => 'userId',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => 2,
      'id' => 'wur3856oyl2qk5itpv0tp1sq49ix8u',
      'label' => 'Пользователь',
      'indexEnabled' => 1,
      'class' => 'user',
    ),
    3 => 
    array (
      'name' => 'amount',
      'type' => 'nmu2-78a6-tcl6-owus-t4vb',
      'editable' => 2,
      'id' => 'b785idkv0qka0dklb74azjmasx4lsn',
      'group' => 'Сумма',
      'indexEnabled' => 1,
    ),
    4 => 
    array (
      'name' => 'comment',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => 2,
      'id' => '3p16qwuznm927febdwus7parofehn8',
      'label' => 'Комментарий',
      'indexEnabled' => 1,
    ),
  ),
  'indexes' => 
  array (
  ),
);}

/**
     * Взять все записи
     **/
    public static function all() {
        return reflex::get(get_class())->desc("date");
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
    public function reflex_title() {

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
    
    public function reflex_parent() {
        return $this->user();
    }
    
    /**
     * Заполнить данные по умолчанию только что созданого элемента
     **/
    public function reflex_beforeCreate() {
        $this->date(util::now());
    }
    
}
