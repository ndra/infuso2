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
        $event = new \Infuso\Eshop\Handler\CartEvent("eshop/add");
        $event->setItem($p["itemId"]);
        $event->fire();
    }
    
    public function post_delete($p) {
        $cart = Model\Cart::active();
        $cartItem = $cart->items()->eq("id", $p["itemId"]);
        $cartItem->delete();
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
