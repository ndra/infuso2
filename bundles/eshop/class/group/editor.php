<?

class eshop_group_editor extends reflex_editor {

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
	    //if($this->item()->data("skipImportChildren") || $this->item()->skipImport())
	    //    $ret.= " <img src='/eshop/res/lock.png' />";
	    return $ret;
	}
	
	public function beforeEdit() {
	    return user::active()->checkAccess("eshop:editGroup",array(
	        "group" => $this->item(),
		));
	}
	
	public function root() {

	    $ret = array();
        $ret[] = eshop_group::allEvenHidden()->eq("parent",0)->title("Группы товаров")->param("starred",true)->param("tab","eshop")->param("id","hkpc5sg89006bo9e97fe");
        $ret[] = eshop_group::allEvenHidden()->title("Группы товаров без иерархии")->param("tab","eshop")->param("id","nw2f4374ll4wbm8zela2");
	    return $ret;

	}

}
