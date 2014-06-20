<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

class GroupEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Group::inspector()->className();
	}

	public function actions() {
	    return $this->callBehaviours("actions");
	}

	public function icon() {
	    return "folder";
	}

	public function filters() {
	    return array(
	        Group::all()->title("Активные"),
	        Group::all()->inverse()->title("Неактивные"),
	    );
	}

	public function beforeEdit() {
	    return user::active()->checkAccess("eshop:editGroup",array(
	        "group" => $this->item(),
		));
	}

	/**
	 * @reflex-root = on
	 **/
	public function allGroups() {
	    return Group::all()
			->eq("parent",0)
			->title("Группы товаров");
	}
    
	/**
	 * @reflex-child = on
	 **/
	public function subgroups() {
	    return $this->item()->subgroups()
			->param("title","Подгруппы");
	}
	
	/**
	 * @reflex-child = off
	 **/
	public function items() {
		return $this->item()->items()
			->param("title","Товары");
	}
	
}
