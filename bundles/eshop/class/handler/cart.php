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
        $cart->items()->create(array(
            "itemId" => $event->item()->id(),
        )); 
    }
    
    /**
     * @handler = eshop/add
     * @handlerPriority = 99999999
     **/
    public function afterAdd($event) {
        app()->fire("eshop/cart-changed", array(
            "deliverToClient" => true,
            "minicart" => app()->tm("/eshop/minicart")->getContentForAjax(),
		));
    }

}
