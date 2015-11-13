<?

namespace Infuso\Cms\Reflex\Controller;
use Infuso\Core;

/**
 * Контроллер для получения полям своих данных
 * Вызывается полями из формы редактирвоание объекта в reflex_editor_controller
 **/
class Field extends Core\Controller {

    public function postTest() {
        return \user::active()->checkAccess("admin:showInterface");
    }
    
    /**
     * Возвроащает html код для окна добавляения элекмента поля "Список ссылок"
     **/         
    public function post_linksAdd($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["editor"]);
        $item = $editor->item();
        $field = $item->field($p["field"]);
		return app()->tm("/reflex/fields/links/add/")->param(array(
            "editor" => $editor,
            "field" => $field,  
        ))->getContentForAjax();
    }
    
    /**
     * Возвроащает html код для окна добавляения элекмента поля "Список ссылок"
     **/         
    public function post_linksAddItems($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["editor"]);
        $item = $editor->item();
        $field = $item->field($p["field"]);
		return app()->tm("/reflex/fields/links/add/ajax")->param(array(
            "editor" => $editor,
            "field" => $field,  
            "search" => $p["search"],
            "page" => $p["page"],
        ))->getContentForAjax();
    }
    
    /**
     * Возвращает html списка элементов для поля "Список ссылок"
     **/         
    public function post_linksContent($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["editor"]);
        $class = get_class($editor->item());
        $item = new $class;
        $field = $item->field($p["field"]);
        $field->value($p["value"]);
        
        return app()->tm("/reflex/fields/links/ajax-items/")
            ->param("field", $field)
            ->getCOntentForAjax();
    }

}
