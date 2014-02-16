<?

/**
 * Модель производителя
**/
class eshop_vendor extends reflex {

	

public static function recordTable() {return array (
  'name' => 'eshop_vendor',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'fgs3ce0okgiok1bdpvrqw92d8lbx8u',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'param' => '',
      'help' => '',
    ),
    1 => 
    array (
      'id' => '0oylsdcvsnfazokubtpa0opahjw9rq',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Наименование',
      'param' => '',
      'help' => '',
    ),
    2 => 
    array (
      'id' => '7parofehn8a6o8vsokardf1bnmu2o8',
      'name' => 'logo',
      'type' => 'knh9-0kgy-csg9-1nv8-7go9',
      'editable' => '1',
      'label' => 'Логотип',
      'param' => '',
      'help' => '',
    ),
    3 => 
    array (
      'id' => 'pg2d410ok5snpvhqk5bnyvbqya0om9',
      'name' => 'active',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Активный',
      'param' => '',
      'help' => '',
    ),
    4 => 
    array (
      'id' => '7fezq81sjyl67pebofuitk1inklit4',
      'name' => 'descr',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '1',
      'label' => 'Описание',
      'param' => '',
      'help' => '',
    ),
    5 => 
    array (
      'id' => '89inmuhx4l2dk5rdc103ca6oyasnkg',
      'name' => 'importKey',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '2',
      'label' => 'Ключ импорта',
      'param' => '',
      'help' => '',
    ),
    6 => 
    array (
      'id' => 'ar7p1i3c12xc1bqf1it8vrjc9bqf52',
      'name' => 'importCycle',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '0',
      'label' => 'Цикл импорта',
      'param' => '',
      'help' => '',
    ),
    7 => 
    array (
      'id' => 'c1sowesnkuso8l2nkaiqy9r3wlioy5',
      'name' => 'numberOfItems',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '2',
      'label' => 'Количество товаров',
      'param' => '',
      'help' => '',
    ),
  ),
);}

/**
	 * Включаем экшны
	 **/
	public static function indexTest() {
		return true;
	}

	/**
	 * Экшн списка товаров
	 **/
	public static function index() {
	    tmp::exec("eshop:vendors");
	}

	/**
	 * Экшн страницы товара
	 **/
	public static function index_item($p) {
	    tmp::exec("eshop:vendor",self::get($p["id"]));
	}

	/**
	 * Вернет коллекцию всех активных производителей
	 **/
	public static function all() {
		return self::allEvenHidden()->eq("active",1)->gt("numberOfItems",0);
	}

	/**
	 * Вернет коллекцию всех производителей, даже тех что неактивны
	 **/
	public static function allEvenHidden() {
		return reflex::get(get_class())->asc("title");
	}

	/**
	 * @return Возвращает производителя по id
	 **/
	public static function get($id) {
		return reflex::get(get_class(),$id);
	}

	/**
	 * Возвращает коллекцию групп товаров данного производителя,
	 * Упорядоченную по количеству товаров в группе
	 **/
	public function groups() {
	    $items = eshop_group::all();
	    if($this->exists()) {
		    $items->join("eshop_item","`eshop_group`.`id`=`eshop_item`.`parent` and `eshop_item`.`vendor` = {$this->id()} and `eshop_item`.`active`");
		    $items->groupBy("eshop_group.id");
		    $items->orderByExpr("count(*) desc");
		    $items->limit(20);
	    } else {
	        $items->eq("id",-1);
	    }
	    return $items;
	}

	/**
	 * Возвращает коллекцию товаров данного производителя
	 **/
	public function items() {
		return eshop_item::all()->eq("vendor",$this->id());
	}

	public function reflex_children() {
	    return array(
	        $this->items()->title("Товары"),
	    );
	}

	public function updateItemsNumber() {
	    $this->data("numberOfItems",$this->items()->count());
	}

	public function reflex_repairSys() {
	    $this->updateItemsNumber();
	}

	public function reflex_search() {
	    if(!$this->published()) return false;
	    if(mod::conf("eshop:search_eshop")) return $this->title();
	}

	public function reflex_bigSearchSnippet() {
	    ob_start();
	    tmp::exec("eshop:search.vendorBigSnippet",$this);
	    return ob_get_clean();
	}

	public function reflex_searchWeight() {
		return 20;
	}

	public function reflex_meta() {
		return true;
	}

	public function reflex_classTitle() {
		return "Производитель";
	}

}
