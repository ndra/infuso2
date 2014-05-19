<?

namespace Infuso\Cms\Log;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;


/**
 * Служба записи в системный лог
 **/
class Handler implements Core\Handler {

    /**
     * @handler = infuso/trace
     **/         
    public function onTrace($event) {
        service("log")->log(array(
            "message" => $event->param("message"),
            "type" => $event->param("type"),
        ));
    }

}
