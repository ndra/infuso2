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
	public function _items() {
		return $this->item()
            ->items()
			->asc("priority")
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
    
    public function metaEnabled() {
        return true;
    }
    
    public function filters($collection) {    
        $ret = array();
        foreach(Group::enumStatuses() as $status => $title) {
            $ret[$title] = $collection->copy()->eq("status", $status);
        }
        $ret["Все"] = $collection->copy();
        return $ret;    
    }
	
}
