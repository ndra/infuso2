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
        
        $cartItem = $cart->items()->eq("itemId", $event->item()->id())->one();
        
        if($cartItem->exists()) {
            $event->update($cartItem);
            $event->cartItemData(array(
                "quantity" => $cartItem->data("quantity") + $event->quantity(),
            ));
        } else {
            $event->create();
            $event->cartItemData(array(
                "itemId" => $event->item()->id(),
                "quantity" => $event->quantity(),
            ));
        }
        
    }
    
    /**
     * @handler = eshop/add
     * @handlerPriority = 99999999
     **/
    public function afterAdd($event) {   
    
        if($event->isCreate()) {
            $event->cart()->items()->create($event->cartItemData()); 
        } else {
            foreach($event->cartItemData() as $key => $val) {
                $event->cartItem()->data($key, $val);
            }
        }
    
        app()->fire("eshop/cart-changed", array(
            "deliverToClient" => true,
            "minicart" => app()->tm("/eshop/minicart")->getContentForAjax(),
		));
    }

}
