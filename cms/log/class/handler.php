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
    
    /**
     * @handler = infuso/deploy
     **/        
    public function onDeploy() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "cleanup",
            "crontab" => "0 0 * * *",
        ));
    }
    
    public static function cleanup() {
        service("log")->all()
            ->lt("datetime", \util::now()->shiftDay(-14))->delete();    
    }

}
