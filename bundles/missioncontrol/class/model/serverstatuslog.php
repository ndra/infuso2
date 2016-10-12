<?

namespace Infuso\Missioncontrol\Model;
use Infuso\Core;

/**
 * Модель записи server-status
 **/
class ServerStatusLog extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            "name" => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'datetime',
                    'type' => 'datetime',
                    'editable' => 2,
                    'label' => 'Время',
                    "default" => "now()",
                ), array (
                    'name' => 'log',
                    'type' => 'textarea',
                    'editable' => 1,
                    'label' => 'Лог сервера',
                ),
            ),
        );
    } 

    public static function all() {
        return service("ar")
            ->collection(get_class());
    }

    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }
	
}
