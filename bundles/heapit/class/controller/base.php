<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

abstract class Base extends Core\Controller {

    public final function indexTest() {
        return app()->user()->exists();
        return true;
    }
    
    public final function indexFailed() {
        app()->tm()->exec("/heapit/login");
    }
    
    public final function postTest() {
        return app()->user()->exists();
    }
}
