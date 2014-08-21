<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель товара в заказе
 **/
class CartItem extends \Infuso\ActiveRecord\Record {

	public static function model() {
        return array (
      		'name' => 'eshop_cart_item',
      		'fields' => array (
			    array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'label' => 'Первичный ключ',
					'indexEnabled' => '0',
				), array (
					'name' => 'cartId',
					'type' => 'link',
					'label' => 'ID заказа',
                    'class' => Cart::inspector()->className(),
				), array (
					'name' => 'itemId',
					'type' => 'link',
					'label' => 'ID заказа',
                    'class' => Item::inspector()->className(),
				), array (
					'name' => 'quantity',
					'type' => 'bigint',
					'label' => 'Количество',
                    "editable" => 1,
                    "default" => 1,
				),
            ),
        );
    }

	public static function all() {
	    return service("ar")
            ->collection(get_class());
	}
    
	public static function get($id) {
	    return service("ar")->get(get_class(),$id);
	}
    
	/**
	 * Возвращает объект товара
	 **/
    public function item() {
        return $this->pdata("itemId");
    }
    
    public function recordParent() {
        return $this->pdata("cartId");
    }

    /**
     * Возвращает цену адиницы товара
	 **/
    public function itemPrice() {
        return $this->item()->data("price");
    }

    /**
     * Возвращает сумму по строке (цена * количество)
	 **/
    public function totalPrice() {
        return $this->item()->data("price") * $this->quantity();
    }
    
    /**
     * Возвращает количество товаров
	 **/
    public function quantity() {
        return $this->data("quantity");
    }
    
}
