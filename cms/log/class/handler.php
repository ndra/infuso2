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
        service("log")->log($event->params());
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
    
    /**
     * Удаляем старые записи в логе
     **/         
    public static function cleanup() {
        service("log")->all()
            ->lt("datetime", \util::now()->shiftDay(-14))->delete();    
    }
    
    /**
     * Обработчик события Хартбит
     * @handler = Infuso/heartbeat
     **/
    public function onHeartbeat($event) {
        
        $errors7Days = service("log")->all()
            ->eq("type", "error")
            ->gt("datetime", \Infuso\Util\Util::now()->day(-7))
            ->count();
            
        $errors1Day = service("log")->all()
            ->eq("type", "error")
            ->gt("datetime", \Infuso\Util\Util::now()->day(-1))
            ->count();
            
        if($errors1Day > 0) {
            $event->error("За последние 24 часа имеются ошибки в логе");
        } elseif($errors7Day > 0) {
            $event->warning("За последние 7 дней имеются ошибки в логе");
        } else {
            $event->message("За последние 7 дней в логе нет ошибок");
        }
        
    }

}
