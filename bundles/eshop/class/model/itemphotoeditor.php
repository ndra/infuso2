<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class ItemPhotoEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return ItemPhoto::inspector()->className();
	}

	public function beforeEdit() {
	    return user::active()->checkAccess("eshop:editItem",array(
	        "item" => $this->item(),
		));
	}
}
