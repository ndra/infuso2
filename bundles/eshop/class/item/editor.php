<?

/**
 * Поведение по умолчаниб для редактора товара
 **/
class eshop_item_editor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return "eshop_item";
	}

	public function defaultBehaviours() {
		$ret = parent::defaultBehaviours();
		$ret[] = "eshop_item_editorBehaviour";
		return $ret;
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
	    return eshop_item::all()
			->title("Товары");
	}

}
