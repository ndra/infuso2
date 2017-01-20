<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;

/**
 * Контроллер управления мета-данными через админку
 **/
class Meta extends \Infuso\Core\Controller {

	/**
	 * На свякий случай, ограничиваем доступ к контроллерам метаданных только для
	 * зарегистрированных пользователей
	 **/
	public static function postTest() {
		return app()->user()->checkAccess("admin:showInterface");
	}
    
    public function post_getMeta($p) {    
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
		return app()->tm("/reflex/meta/content/ajax")->param("editor",$editor)->getContentForAjax();
    }
    
    public function post_create($p) {     
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $item = $editor->item();
        $item->plugin("meta")->create();    
    }
    
    public function post_save($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);

        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $item = $editor->item()->plugin("meta")->metaObject();
        $item->setData($p["data"]);
        app()->msg("Метаданные сохранены");
    }
    
    public function post_remove($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $item = $editor->item()->plugin("meta")->metaObject();
        $item->delete();
        app()->msg("Метаданные удалены");
    }
    
}


