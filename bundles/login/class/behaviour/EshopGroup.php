<?

namespace Infuso\Site\Behaviour;
use \Infuso\Core;

class EshopGroup extends Core\Behaviour {

    public static function model() {
        return array(
            "fields" => [
                [
                    "label" => "Фото",
                    "type" => "file",
                    "name" => "img",
                    "editable" => 2,
                ],
            ],
        );
    }

	public static function addToClass() {
		return "Infuso\\Eshop\\Model\\Group";
	}

}
