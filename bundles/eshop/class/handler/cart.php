<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class Cart implements Core\Handler {

    /**
     * @handler = eshop/add
     * @handlerPriority = -1     
     **/         
    public function handleAdd($event) {
        $cart = Model\Cart::getActiveCreateIfNotExists(); 
        $event->setCart($cart->id()); 
        app()->msg($event->cart()->id()); 
    }

}
