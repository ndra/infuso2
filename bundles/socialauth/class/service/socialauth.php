<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Служба для авторизации через соцсети
 **/
class SocialAuth extends Core\Service {

    public function defaultService() {
        return "socialauth";
    }

    public function provider($name) {
    }

}
