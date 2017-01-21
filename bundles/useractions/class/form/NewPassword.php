<?

namespace Infuso\UserActions\Form;
use Infuso\Core;

class NewPassword extends \Infuso\CMS\Form\Base {

    public static function model() {
        return [
            "fields" => [
                [
                    "name" => "password",
                    "type" => "string",
                    "editable" => 1,
                    "validationCallback" => [get_class(), "validatePassword"],
                ],[
                    "name" => "password2",
                    "type" => "string",
                    "editable" => 1,
                    "validationCallback" => [get_class(), "validatePassword2"],
                ],
            ],  
        ];
    }
    
    public static function validatePassword($event) {        
        $password = $event->data()["password"];                       
        $errorText = "";
        $password = service("user")->checkAbstractPassword($password, $errorText);
        if(!$password) {
            $event->error("password", $errorText);
            return;
        }
        $event->valid();
    }
    
    public static function validatePassword2($event) {       
        if($event->value() != $event->data()["password"]) {
            $event->error("password2", "Пароль и повтор пароля не совпадают");
            return;
        }
        $event->valid();
    }

} 