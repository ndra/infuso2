<?

namespace Infuso\Cms\Heartbeat;
use Infuso\Core;

class Handler implements Core\Handler {


    /**
     * @handler = infuso/beforeAction
     **/         
    public function beforeAction() {
        app()->tm()->add("admin-header", "/heartbeat/widget");
    }

}
