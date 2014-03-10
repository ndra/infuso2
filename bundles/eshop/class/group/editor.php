<?

class eshop_group_editor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return "eshop_group";
	}

	public function actions() {
	    return $this->callBehaviours("actions");
	}

	public function icon() {
	    return "folder";
	}

	public function filters() {
	    return array(
	        eshop_group::all()->title("Активные"),
	        eshop_group::all()->inverse()->title("Неактивные"),
	    );
	}

	public function render() {
	    $ret = $this->item()->title();
	    return $ret;
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
	    return eshop_group::allEvenHidden()
			->eq("parent",0)
			->title("Группы товаров")
			->param("starred",true)
			->param("tab","eshop");
	}
	
	/**
	 * @reflex-root = on
	 **/
	public static function allGroupWithoutHierarchy() {
	    return eshop_group::allEvenHidden()
			->title("Группы товаров без иерархии")
			->param("tab","eshop");
	}
	
}
