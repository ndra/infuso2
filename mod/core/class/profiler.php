<?

namespace Infuso\Core;

class Profiler {

    /**
     * переменная для временного хранения стэка текущих операций
     **/
    public static $stack = array();
  
    /**
     * Основной массив с данными профайлера
     **/
    private static $data = array();
    
    /**
     * id текущего запуска
     **/
    private static $id;
    
    public static function enabled() {
        return Superadmin::check();
    }
    
    public static function id() {
    
        if(!self::$id) {
            self::$id = "ArwPr30x-".crc32(microtime(1));
        }
    
        return self::$id;
    }
    
    /**
     * Открывает новую операцию
     **/
    public static function beginOperation($group, $operation, $key) {

        if(!self::enabled()) {
            return;
        }

        $key = (String)$key;

        self::$stack[] = array(
            $group,
            $operation,
            $key,
            microtime(1),
        );

    }

    /**
     * Обновляет текущую опрецию
     **/
    public static function updateOperation($group, $operation, $key) {

        if(!self::enabled()) {
            return;
        }

        $key.="";

        $n = sizeof(self::$stack)-1;
        $time = self::$stack[$n][3];

        self::$stack[$n] = array(
            $group,
            $operation,
            $key,
            $time
        );

    }

    /**
     * Закрывает операцию
     **/
    public static function endOperation() {

        if(!self::enabled()) {
            return;
        }  

        $item = array_pop(self::$stack);
        $time = microtime(true) - $item[3];
        self::$data["log"][$item[0]][$item[1]]["time"] += $time;
        self::$data["log"][$item[0]][$item[1]]["keys"][$item[2]]["count"] ++;
        self::$data["log"][$item[0]][$item[1]]["keys"][$item[2]]["time"] += $time;

        self::$data["operations"] = array(
            "s" => $item[3] - $GLOBALS["infusoStarted"],
            "d" => $time,
            "n" => $item[0]."/".$item[1]."/".$item[2],
		);

    }

	/**
	 * Добавляет майлстоун (контрольную точку)
	 **/
    public function addMilestone($name) {

        if(!self::enabled()) {
            return;
        }

        self::$data["milestones"][] = array(
            $name,
            microtime(true),
        );
    }
    
   
    public function setVariable($key,$val) {
        self::$data["variables"][$key] = $val;
    }

    public static function sortLog($a,$b) {
        $r = $b["time"] - $a["time"];
        if($r > 0) return 1;
        if($r < 0) return -1;
        return 0;
    }

    public function log() {
        foreach(self::$data["log"] as $k1 => $a) {
            foreach($a as $k2 => $b) {
                $keys = $b["keys"];
                uasort($keys, array(self,"sortLog"));
                self::$data["log"][$k1][$k2]["keys"] = $keys;
            }
        }
        return self::$data["log"];
    }
    
    public static function getData() {
        return self::$data;
    }
    
}
