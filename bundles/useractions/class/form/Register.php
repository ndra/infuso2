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
                    "validationCallback" => [get_class(), "validateEmail"],
                ], [
                    "name" => "password",
                    "type" => "string",
                    "label" => "Пароль",
                    "error" => "Укажите пароль",
                    "editable" => 1,
                    "validationCallback" => [get_class(), "validatePassword"],
                ],[
                    "name" => "password2",
                    "type" => "string",
                    "label" => "Повтор пароля",
                    "error" => "Пароли должны совпадать",
                    "editable" => 1,
                    "validationCallback" => [get_class(), "validatePassword2"],
                ],
            ],
        ];
    }
    
    public static function validateEmail($event) {        
        $email = $event->data()["email"];        
        $user = service("user")->byEmail($email);
        if($user->exists()) {
            $event->error("email", "Пользователь с такой электронной почтой уже зарегистрирован");
            return;
        }
        $event->valid();
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