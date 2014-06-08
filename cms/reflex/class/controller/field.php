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
        return var_export($p,1);
    }

}
