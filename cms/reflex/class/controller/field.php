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
    
    public function post_linksAdd($p) {
        $editor = \Infuso\CMS\Reflex\Editor::get($p["editor"]);
        $item = $editor->item();
        $field = $item->field($p["field"]);
        return \tmp::get("/reflex/fields/links/add/")
            ->param("editor", $editor)
            ->param("field", $field)
            ->getCOntentForAjax();
    }

}
