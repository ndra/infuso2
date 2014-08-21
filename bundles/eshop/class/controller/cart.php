<?

namespace Infuso\Eshop\Controller;
use \Infuso\Core;
use \Infuso\Eshop\Model;

/**
 * Контроллер для управления заказом
 **/
class Cart extends Core\Controller {

    public function controller() {
        return "cart";
    }

    public function indexTest() {
        return true;
    }
    
    public function postTest() {
        return true;
    }
    
    /**
     * Контроллер добавления товара в корзину
     **/
    public function post_add($p) {

		$items = $p["items"];
    
        if(!is_array($items)) {
            throw new \Exception("\$_POST['items'] must be array");
        }
        
        foreach($items as $itemData) {
            $event = new \Infuso\Eshop\Handler\CartEvent("eshop/add");
			foreach($itemData as $key => $val) {
			    $event->requestData($key, $val);
			}
	        $event->setItem($itemData["id"]);
	        $event->fire();
        }
    }
    
	/**
     * Удаление элемента из корзины
     **/
    public function post_delete($p) {
        $cart = Model\Cart::active();
        $cartItem = $cart->items()->eq("id", $p["itemId"]);
        $cartItem->delete();
    }
    
    /**
     * Очистка корзины
     **/
    public function post_clear($p) {
        $cart = Model\Cart::active();
        $cart->items()->delete();
    }
    
	/**
	 * Сохрвняет данные пользователя
	 **/
    public function post_submit($p) {
        $cart = Model\Cart::active();
        $cart->scenario("submit");
        $cart->fill($p);
    }
        
    public function index() {
        $cart = Model\Cart::active();
        app()->tm("/eshop/cart")->param("cart", $cart)->exec();
    }
    
    public function index_form() {
        $cart = Model\Cart::active();
        app()->tm("/eshop/cart-form")->param("cart", $cart)->exec();
    }

}
