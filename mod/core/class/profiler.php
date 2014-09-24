<?

namespace Infuso\Core;

class Profiler {

    public static $stack = array();

    public static $log = array();

    private static $variables = array();

    private static $milestones = array();
    
    public static $operations = array();
    
    private static $paused = false;
    
    public static function enabled() {
        return false;
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
     * Открывает новую операцию
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

        if(!self::$paused) {

	        $item = array_pop(self::$stack);
	        $time = microtime(true) - $item[3];
	        self::$log[$item[0]][$item[1]]["time"] += $time;
	        self::$log[$item[0]][$item[1]]["keys"][$item[2]]["count"] ++;
	        self::$log[$item[0]][$item[1]]["keys"][$item[2]]["time"] += $time;

	        self::$operations[] = array(
	            "s" => $item[3] - $GLOBALS["infusoStarted"],
	            "d" => $time,
	            "n" => $item[0]."/".$item[1]."/".$item[2],
			);

		}

    }

	/**
	 * Добавляет майлстоун (контрольную точку)
	 **/
    public function addMilestone($name) {

        if(!self::enabled()) {
            return;
        }

        self::$milestones[] = array(
            $name,
            microtime(true),
        );
    }
    
    public function start() {
        self::setVariable("start",microtime(1));
    }
    
	public function stop() {
	    self::setVariable("stop",microtime(1));
	    self::addMilestone("done");
    }
    
    public function pause() {
        self::$paused = true;
    }
    
	public function resume() {
	    self::$paused = false;
    }

    public function setVariable($key,$val) {
        self::$variables[$key] = $val;
    }

    public function getVariable($key) {
        return self::$variables[$key];
    }

    public function getMilestones() {
        return self::$milestones;
    }

    public static function sortLog($a,$b) {
        $r = $b["time"] - $a["time"];
        if($r>0) return 1;
        if($r<0) return -1;
        return 0;
    }

    public function log() {

        foreach(self::$log as $k1=>$a) {
            foreach($a as $k2=>$b) {

                $keys = $b["keys"];
                uasort($keys,array(self,"sortLog"));
                self::$log[$k1][$k2]["keys"] = $keys;
            }
        }
        return self::$log;
    }
}
