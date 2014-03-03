<?

class user_editor extends reflex_editor {

    public function beforeEdit() {
        return user::active()->checkAccess("user:editorStore");
    }
    
    
    public function beforeView() {
        return user::active()->checkAccess("user:editorView");    
    }
    
    public function beforeCollectionView() {
        return user::active()->checkAccess("user:editorCollectionView");    
    }
    
    public function root() {

        $ret = array();

        if(user::active()->checkAccess("user:showInCatalogMenu")) {
            $ret[] = user::all()->title("Пользователи")->param("tab","user")->param("id","f8qaql7hxgc87rs6sgcs");
        }

        return $ret;
    }
    
}
