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
    
    public function post_create($p) {
    
        $editor = \Infuso\CMS\Reflex\Editor::get($p["index"]);
        $item = $editor->item();
        $item->plugin("meta")->create();
    
    }

	/**
	 * Контроллер получения метаданных объекта
	 **/
	public static function post_get($p) {
	
		$editor = reflex_editor::byHash($p["index"]);
		$item = $editor->item()->metaObject();
		
		if(!$editor->beforeView()) {
			mod::msg("У вас нет доступа для просмотра метаданных",1);
			return fasle;
		}
		
		if($item->exists()) {
		
			$data = $item->editor()->inxForm();
			
			return array(
				"form" => $data,
			);
			
		} else {
		    return array(
		        "error" => "У данного объекта отсутствуют метаданные."
			);
		}
		
	}

	/**
	 * Контроллер сохранения метаданных
	 **/
	public static function post_save($p) {
	
	    $editor = reflex_editor::byHash($p["index"]);

		if(!$editor->beforeEdit()) {
		    mod::msg("Вы не можете редактировать метаданные этого объекта",1);
		    return;
		}

		$editor->saveMeta($p["data"],$p["lang"]);

		mod::msg("Мета: данные сохранены");
	}

	/**
	 * Контроллер удаления метаданных
	 **/
	public static function post_delete($p) {
	
	    $editor = reflex_editor::byHash($p["index"]);

		if(!$editor->beforeEdit()) {
		    mod::msg("Вы не можете удалить метаданные этого объекта",1);
		    return;
		}

		$editor->deleteMeta($p["lang"]);
		
		mod::msg("Данные удалены");
	}

}
