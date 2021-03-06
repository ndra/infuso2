<?

namespace Infuso\CMS\Form\Controller;
use \Infuso\Core;

/**
 * Контроллер-валидатор для форм
 **/
class Validator extends Core\Controller {

    public function postTest() {
        return true;
    }

    public function post_validate($p) {
    
        $formName = $p["form"];
        $form = new $formName();
        $form->scenario($p["scenario"]);
        $valid = $form->validate($p["data"]);
        $errors = $form->getValidationErrors();
        
        return array(
            "valid" => $valid,
            "errors" => $errors, 
        );
    }

}
