<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

abstract class Base extends Core\Controller {

    public final function indexTest() {
        return \Infuso\User\Model\User::active()->exists();
    }
    
    public final function indexFailed() {
        $this->app()->tmp()->exec("/heapit/login");
    }
    
    public final function postTest() {
        return \Infuso\User\Model\User::active()->exists();
    }
}