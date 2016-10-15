<?

namespace Infuso\Missioncontrol\Handler;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Дефолтный хэндлер
 **/
class Main implements Core\Handler {

    /**
     * @handler = infuso/deploy
     **/
    public function onDeploy() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "saveLog",
            "crontab" => "* * * * *",
            "title" => "Сохранение server-status в лог",
        ));
        
        service("task")->add(array(
            "class" => get_class(),
            "method" => "clearLog",
            "crontab" => "* * * 0 0",
            "title" => "Очистка лога server-status",
            "randomize" => 60 * 24
        ));
        
    }

    /**
     * Сохраняет в лог server-status
     **/
    public static function saveLog() {

        $ctx = stream_context_create(array( 
            'http' => array( 
                'timeout' => .1 
                ) 
            ) 
        ); 
        
        $url = app()->url();          
        file_get_contents($url->scheme()."://".$url->domain()."/missioncontrol/logsaver", 0, $ctx);    

    }
    
    /**
     * Очищает лог server-status
     **/
    public static function clearLog() {

        \Infuso\Missioncontrol\Model\ServerStatusLog::all()
            ->leq("datetime", \Infuso\Util\Util::now()->shiftDays(-7))
            ->delete();

    }
	
}
