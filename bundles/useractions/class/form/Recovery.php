<?

namespace Infuso\UserActions\Form;
use Infuso\Core;

class Recovery extends \Infuso\CMS\Form\Base {

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
                ],
            ],  
        ];
    }

} 