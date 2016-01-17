<?

namespace Infuso\Cms\Heartbeat;
use Infuso\Core;

class Handler implements Core\Handler {


    /**
     * @handler = infuso/beforeAction
     **/         
    public function beforeAction() {
        if(\Infuso\Core\Superadmin::check()) {
            app()->tm()->add("admin-header", "/heartbeat/widget");
        }
    }

}
