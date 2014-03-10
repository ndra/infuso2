<?

class user_editor extends \Infuso\Cms\Reflex\Editor {

    public function beforeEdit() {
        return user::active()->checkAccess("user:editorStore");
    }
    
    
    public function beforeView() {
        return user::active()->checkAccess("user:editorView");    
    }
    
    public function beforeCollectionView() {
        return user::active()->checkAccess("user:editorCollectionView");    
    }
    
    /**
     * @reflex-root = on
     **/
    public function all() {
        return user::all()
			->title("Пользователи")
			->param("tab","user");
    }
    
}
