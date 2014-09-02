<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class GroupEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Group::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = eshop
	 **/
	public function allGroups() {
	    return Group::all()
			->eq("parent",0)
			->param("sort", true)
			->title("Группы товаров");
	}
    
	/**
	 * @reflex-child = on
	 **/
	public function subgroups() {
	    return $this->item()->subgroups()
	        ->param("sort", true)
			->param("title","Подгруппы");
	}
	
	/**
	 * @reflex-child = on
	 **/
	public function items() {
		return $this->item()
            ->items()
            ->param("sort", true)
			->param("title","Товары");
	}
	
	public function _layout() {
	    return array(
			"collection:items",
			"collection:subgroups",
			"<div style='border-bottom: 3px solid #ccc;' ></div>",
			"form",
		);
	}
	
    public function listItemTemplate() {
        return app()->tm("/eshop/admin/group-list-item")
            ->param("editor", $this);
    }
	
}
