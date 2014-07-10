<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class CartEvent extends Core\Event {

    private $item = null;
    
    private $cart = null;
    
    public function setItem($itemId) {
        $this->item = Model\Item::get($itemId);
        return $this;
    }
    
    public function item() {
        return $this->item;
    }
    
    public function setCart($cartId) {
        $this->cart = Model\Cart::get($cartId);
        return $this;
    }
    
    public function cart() {
        return $this->cart;
    }

}
