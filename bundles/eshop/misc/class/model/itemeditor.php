<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class ItemEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Item::inspector()->className();
	}

	public function beforeEdit() {
	    return app()->user()->checkAccess("eshop:editItem",array(
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
	public function _photos() {
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
    
    public function metaEnabled() {
        return true;
    }
    
    public function filters($collection) {    
        $ret = array();
        foreach(Item::enumStatuses() as $status => $title) {
            $ret[$title] = $collection->copy()->eq("status", $status);
        }
        $ret["Все"] = $collection->copy();
        return $ret;    
    }

}
