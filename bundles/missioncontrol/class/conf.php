<?

namespace Infuso\Missioncontrol;

/**
 * Класс-конфигуратор
 **/
class Conf extends \Infuso\Core\Component {

    public static function initialParams() {
        return array(
            "server-status" => "http://localhost/server-status",
        );
    }

}
