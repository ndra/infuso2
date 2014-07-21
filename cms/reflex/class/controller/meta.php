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
		return \user::active()->checkAccess("admin:showInterface");
	}
    
    public function post_getMeta($p) {    
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
		return app()->tm("/reflex/meta/content/ajax")->param("editor",$editor)->getContentForAjax();
    }
    
    public function post_create($p) {     
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        $item = $editor->item();
        $item->plugin("meta")->create();    
    }
    
    public function post_save($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        $editor->setMeta($p["data"]);
        app()->msg("Метаданные сохранены");
    }
    
    public function post_remove($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        $editor->deleteMeta();
        app()->msg("Метаданные удалены");
    }
    
}


