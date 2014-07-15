<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class CartItemEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return CartItem::inspector()->className();
	}
    
}
