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
                ],[
                    "name" => "password-2",
                    "type" => "string",
                    "editable" => 1,
                ],
            ],  
        ];
    }

} 