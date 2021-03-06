<?
/**
 * Контроллер крона
 **/
class mod_cron_service extends \infuso\core\service Implements Infuso\Core\Handler {

	public function defaultService() {
	    return "cron";
	}

	public function initialParams() {
	    return array(
	        "minDelay" => 10,
	        "delayMultiplier" => 10,
		);
	}
	
	public static function confDescription() {
	    return array(
	        "components" => array(
	            get_class() => array(
	                "params" => array(
	                    "minDelay" => "Минимальная задержка между вызовами",
	                    "delayMultiplier" => "На сколько секунд увеличивать задержку при увеличении времени запуска на 1 секунду",
					),
				),
			),
		);
	}

    /**
     * Проверяет, когда был запущен последний раз крон
     * (Предотаращает слишком частый запуск крона)
     * Выполняет задачу
     **/
    public function checkTimeAndprocess() {

        $file = file::get(app()->varPath()."/cron.php");
        $time = $file->time();

        // Читаем статус из файла
        $status = $file->contents();

        // Если в статусе написано, что крон завершился,
        // Определяем время работы крона, умножаем на 10
        // Следующий запуск крона возможен не раньше, чем длительность предыдущего запуска * 10 + 10
        // Т.е. если скрипт выполнялся 8 с., то следующий запуск возможен через 8*10+10 = 90 с.
        if(preg_match("/done:\s*(\d+)/", $status, $matches)) {
            $s = $matches[1];
            $delay = max($s * $this->param("delayMultiplier"), $this->param("minDelay"));
        } else {
            $delay = 3600;
        }

        $left = $time->stamp() + $delay - util::now()->stamp();

        // Рарзрешаем обработчикам крона запуститься только если истек кулдаун или мы в режиме суперадмина
        if($left < 0 || \mod_superadmin::check()) {
            $file->put("processing");
            $t1 = \util::now()->stamp();
            self::process();
            $t2 = \util::now()->stamp();
            $time = $t2 - $t1;
            $file->put("done: ".$time);
        }

        // Выводим инфу
        if(\mod_superadmin::check()) {            
            \infuso\cms\admin\admin::header();
            
            echo "<div style='padding:100px;' >";
            echo "Time to next launch ".$left." sec.";
            echo "</div>";
            
            \infuso\template\lib::reset();
            \infuso\cms\admin\admin::footer();

            if(array_key_exists("loop",$_GET)) {
                echo "<script>window.location.reload();</script>";
            }                 
        }    
    }

    /**
     * Выполняет задачу без дополнительных проверок
     **/
    public function process() {
    
        $begin = microtime(true);
        app()->fire("infuso/cron");
        $time = microtime(true) - $begin;
        
        app()->msg($time);
        
        service("log")->log(array(
            "type" => "cron",
            "message" => "completed: {$time} s.",
            "p1" => $time,
		));
        
    }
    
    /**
     * Возвращает коллекцию записей в логе для крона
     **/
    public function getLog() {
        return reflex_log::all()->eq("type","cron");
    }
    
    /**
     * Обработчик события Хартбит - теста системы
     * @handler = Infuso/heartbeat
     **/
    public function onHeartbeat($event) {
    
        $last = service("log")
            ->all()
            ->eq("type", "cron")
            ->desc("datetime")
            ->one();
        
        if(!$last->exists()) {
            $event->error("Крон не был запущен ни разу");
            return;
        }
        
        $d = util::now()->stamp() - $last->pdata("datetime")->stamp();
        if($d > 3600) {
            $event->error("Крон был запущен {$last->pdata('datetime')->num()} назад");
            return;
        }
    
        $event->message("Последний запуск крона ".$last->pdata("datetime")->num());
    }

}
