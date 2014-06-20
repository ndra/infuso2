<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class ItemEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Item::inspector()->className();
	}

	public function beforeEdit() {
	    return user::active()->checkAccess("eshop:editItem",array(
	        "item" => $this->item(),
		));
	}
	
	/**
	 * @reflex-root = on
	 **/
	public function allItems() {
	    return Item::all()
			->title("Товары");
	}

}
