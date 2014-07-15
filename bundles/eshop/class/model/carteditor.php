<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class CartEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Cart::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = eshop
	 **/
	public function orders() {
	    return Cart::all()
			->title("Заказы");
	}
    
    public function templateEditBeforeForm() {
        return app()->tm("/eshop/admin/cart-items")
            ->param("editor", $this);    
    }
    
}
