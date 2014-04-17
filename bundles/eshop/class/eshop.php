<?

/**
 * Онсновной класс модуля «интернет-магзин
 * В этом классе содержатся быстрые алиасы для конструкторов и различные настройки
 **/

class eshop extends reflex {

	/**
	 * Включаем экшны
	 **/
	public function indexTest() {
		return true;
	}

	/**
	 * Контроллер главной страницы заказа
	 **/
	public function index() {
		mod::app()->tmp()->template("/eshop/title")->exec();
	}

	/**
	 * У класса eshop нет таблицы, хотя он расширяет reflex
	 * У этого класса есть только reflex_root()
	 **/
	public static function recordTable() {
		return null;
	}

	/**
	 * Возвращает коллекцию групп верхнего уровня
	 **/
	public static function groups() {
		return eshop_group::all()->eq("parent",0);
	}

	/**
	 * Возвращает группу по id
	 **/
	public static function group($id) {
		return eshop_group::get($id);
	}

	/**
	 * @return Возвращает товар по его id
	 **/
	public static function item($id) {
		return eshop_item::get($id);
	}

	/**
	 * @return Возвращает коллекциб всех товаров
	 **/
	public static function items() {
	    return eshop_item::all();
	}

	/**
	 * @return Возвращает коллекцию производителей
	 **/
	public static function vendors() {
		return eshop_vendor::all();
	}

	/**
	 * @return Возвращает объект заказа
	 * @param $id ID Заказа
	 **/
	public static function order($id) {
		return eshop_order::get($id);
	}

	/**
	 * @return Возвращает коллекцию всех заказов
	 **/
	public static function orders() {
		return eshop_order::all();
	}

	/*public static function reflex_root() {

	    $ret = array();

        $ret[] = eshop_group::allEvenHidden()->eq("parent",0)->title("Группы товаров")->param("starred",true)->param("tab","eshop");
        $ret[] = eshop_group::allEvenHidden()->title("Группы товаров без иерархии")->param("tab","eshop");
        $ret[] = eshop_item::allEvenHidden()->title("Товары")->param("starred",true)->param("tab","eshop");
        $ret[] = reflex::get("eshop_order")->param("icon","basket")->desc("sent")->title("Заказы")->addBehaviour("eshop_order_collection")->param("starred",true)->param("tab","eshop");
        $ret[] = eshop_vendor::allEvenHidden()->title("Производители")->param("tab","eshop");

	    return $ret;

	} */

}
