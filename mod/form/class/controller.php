<?

namespace Infuso\Form;
use \Infuso\Core;

/**
 * Контроллер-валидатор для форм
 **/
class Controller extends Core\Controller {

    public function postTest() {
        return true;
    }

    public function post_validate() {
        app()->msg("validate");
    }

}
