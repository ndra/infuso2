<?

/**
 * Модель позиции в заказе
 **/ 
class eshop_order_item extends reflex {

	

public static function model() {return array (
  'name' => 'eshop_order_item',
  'fields' => 
  array (
    0 => 
    array (
      'id' => '81bjfezqp16nwgz3ca6x85sxfe6qmv',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'help' => '',
    ),
    1 => 
    array (
      'id' => '3p1274vr7fu27cgrt890dk52dw1r78',
      'name' => 'orderID',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'help' => '',
    ),
    2 => 
    array (
      'id' => 'cviokv2dmusnp92xp9hjmvijmghqkl',
      'name' => 'itemID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'label' => 'Товар',
      'default' => '',
      'help' => '',
      'class' => 'eshop_item',
      'collection' => '',
      'titleMethod' => '',
    ),
    3 => 
    array (
      'editable' => 1,
      'id' => 'pv2tyeroc52ocuhjwlhdyab34lhnk5',
      'name' => 'itemSku',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'label' => 'SKU товара',
      'group' => '',
      'default' => '',
      'indexEnabled' => 0,
      'help' => '',
      'length' => '',
    ),
    4 => 
    array (
      'id' => 'rq8u0q8ur7fg2j4g6nplstfeb349so',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Наименование товара',
      'default' => '',
      'help' => '',
    ),
    5 => 
    array (
      'id' => 'hofu2xm16ncl2opv674gzxwubtk1zo',
      'name' => 'quantity',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '1',
      'label' => 'Кол-во товара',
      'default' => '',
      'help' => '',
    ),
    6 => 
    array (
      'id' => '7ygb7pehx8vsjmvr3cuhnp5b3f1iqf',
      'name' => 'price',
      'type' => 'nmu2-78a6-tcl6-owus-t4vb',
      'editable' => '1',
      'label' => 'Цена за единицу',
      'default' => '',
      'help' => '',
    ),
    7 => 
    array (
      'id' => 'c1ro8gr7p567c1r3wvzxc5ixf1rjyg',
      'name' => 'extra',
      'type' => 'puhj-w9sn-c10t-85bt-8e67',
      'editable' => '1',
      'label' => 'Дополнительно',
      'default' => '',
      'help' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
  'fieldGroups' => 
  array (
    0 => 
    array (
      'name' => NULL,
      'title' => NULL,
    ),
  ),
);}

/**
	 * @return Возвращает коллекцию все позиций во всех заказах
	 **/
	public static function all() {
	    return reflex::get(get_class());
	}

	/**
	 * @return Возвращает позицию заказа по id
	 **/
	public static function get($id) {
	    return reflex::get(get_class(),$id);
	}

	/**
	 * @return Возвращает родителя позиции заказа - объект заказа
	 **/
	public function reflex_parent() {
		return $this->order();
	}

	/**
	 * @return Возвращает товарную позицию, соответствующую позиции в заказе
	 **/
	public function item() {
		return eshop_item::get($this->data("itemID"));
	}

	/**
	 * @return Возвращает объект заказа с которым связана эта позиция
	 **/
	public function order() {
		return eshop_order::get($this->data("orderID"));
	}

	public function reflex_afterOperation() {
	    // Вызываем событие изменения позиции в заказе
	    // На это сообщение подписан него подписан заказ
		mod::fire("eshop_cartContentChanged",array(
			"item" => $this,
			"cart" => $this->order(),
			"deliverToClient" => true,
		));
	}

	public function fireError($txt) {
		mod::fire("eshop_cartItemError",array(
	    	"text" => $txt,
	    	"itemID" => $this->item()->id(),
	    	"orderItemID" => $this->id(),
	    	"deliverToClient" => true,
		));
	}

	/**
	 * Возвращает количество товара
	 **/
	public function quantity() {
		return $this->data("quantity");
	}

	/**
	 * Устанавливает количество товара
	 **/
	public function setQuantity($q) {

		$q = intval($q);
		if($q<=0) {
	     	$this->fireError("Недопустимое значение");
		    return false;
		}

		if(!$this->item()->tryBuy($q)) {
		    $this->fireError("Недостаточно товара в наличии. Максимум — {$this->item()->data(instock)}");
		    return false;
		}

		$this->data("quantity",$q);
		return true;
	}

	/**
	 * Возвращает цену за единицу товара
	 **/
	public function price() {
		if($this->order()->draft())
			return $this->item()->price();
		return $this->data("price");
	}

	/**
	 * Возвращает сумму по строке (цена*количество)
	 **/
	public function cost() {
		return $this->price() * $this->quantity();
	}

	/**
	 * Фиксирует цену и название товарной позиции
	 * После оформления товара цена и наименования товара могут изменитться
	 * Эта функция сохраняет состояние товарной позиции на момент заказа
	 **/
	public function fixItem() {
		$this->data("price",$this->item()->price());
		$this->data("title",$this->item()->title());
	}

	public function reflex_title() {
		if($title = $this->data("title"))
			return $title;
	    if(!$this->item()->exists())
			return "Несуществующая позиция";
	    return $this->item()->title();
	}

	/**
	 * @return url товарной позиции
	 **/
	public function reflex_url() {
		return $this->item()->url();
	}

	public function reflex_cleanup() {
		if(!$this->order()->exists())
	        return true;
	}

	public function extra($key,$val=null) {
	    $extra = $this->pdata("extra");
	    if(func_num_args()==1) {
	        return $extra[$key];
	    }
	    if(func_num_args()==2) {
	        $extra[$key] = $val;
	        $this->data("extra",json_encode($extra));
	    }
	}
	
}
