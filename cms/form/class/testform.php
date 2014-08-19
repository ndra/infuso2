<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
class TestForm extends Base {

    public function formFields() {
        return array(
            array(
                "name" => "field-1",
                "type" => "string",
                "min" => 1,
                "error" => "sdfsdfsdf"
            ), array(
                "name" => "field-2",
                "type" => "string",
                "min" => 2,
            ),
        );
    }

}
