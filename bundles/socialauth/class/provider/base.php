<?

namespace Infuso\UserActions\Provider;
use \Infuso\Core;

/**
 * Базовый класс для провайдера входа через соцсети
 **/
abstract class Provider extends Core\Controller {

    abstract public static function name();

}
