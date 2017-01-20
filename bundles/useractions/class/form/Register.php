<?

namespace Infuso\UserActions\Form;
use Infuso\Core;

class Register extends \Infuso\CMS\Form\Base {

    public static function model() {
        return [
            "fields" => [
                [
                    "name" => "email",
                    "type" => "string",
                    "label" => "Почта",
                    "email" => true,
                    "error" => "Укажите электронную почту",
                    "editable" => 1,
                ], [
                    "name" => "password",
                    "type" => "string",
                    "label" => "Пароль",
                    "error" => "Укажите пароль",
                    "editable" => 1,
                ],[
                    "name" => "password2",
                    "type" => "string",
                    "label" => "Повтор пароля",
                    "error" => "Пароли должны совпадать",
                    "editable" => 1,
                ],
            ],
            "validationCallback" => array(
                get_class(), "validateRegistration"
            ),  
        ];
    }
    
    public static function validateRegistration($p) {
    
        $data = app()->msg($p->data());
    
        return false;
    
    }

} 