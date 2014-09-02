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
	 * @reflex-tab = eshop
	 **/
	public function allItems() {
	    return Item::all()
			->title("Товары");
	}

	/**
	 * @reflex-child = on
	 **/
	public function photos() {
	    return $this->item()
			->photos()
			->param("sort", true)
			->title("Фотографии");
	}
	
	public function _layout() {
	    return array(
	        "form",
	        "collection:photos",
		);
	}
	
    public function listItemTemplate() {
        return app()->tm("/eshop/admin/item-list-item")
            ->param("editor", $this);
    }

}
