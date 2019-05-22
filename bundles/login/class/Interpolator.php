<?

namespace Infuso\Site;

/**
 * Интерполятор
 **/
class Interpolator extends \Infuso\Core\Controller {

    private $keypoints = array();
    
    private $keypointsSorted = false;
        
    public function keypoint($x, $y) {
        $this->keypoints[] = array(
            "x" => $x,
            "y" => $y,
        );
        $this->keypointsSorted = false;
    }
    
    public function keypoints() {
        return $this->keypoints;
    }
    
    public function interpolate($x) {    
    
        if(sizeof($this->keypoints) == 0) {
            return 0;
        }
    
        // Сортируем ключевые точки
        if(!$this->keypointsSorted) {
        
            // Сортируем ключевые точки по $x  
            usort($this->keypoints, function($a, $b) {           
                $sign = function($n) {
                    return ($n > 0) - ($n < 0);
                };        
                return $sign($a["x"] - $b["x"]); 
            });     
            
            $this->keypoints = array_values($this->keypoints);
            $this->keypointsSorted = true;
        }
        
        // Если точка всего одна, возвращаем ее значение (у нас горизонтальный график)
        if(sizeof($this->keypoints) == 1) {
            return $this->keypoints[0]["y"];
        }
        
        if($x <= $this->minX()) {
            $a = $this->keypoints[0];
            $b = $this->keypoints[1];
        } else {        
            for($i = 0; $i < sizeof($this->keypoints) - 1; $i ++) {
                $a = $this->keypoints[$i];
                $b = $this->keypoints[$i + 1];
                if($a["x"] <= $x && $b["x"] >= $x) {
                    break;
                }
            }
        }
        
        $k = ($x - $a["x"]) / ($b["x"] - $a["x"]);
        return $b["y"] * $k + $a["y"] * (1 - $k);
        
    }
    
    public function minX() {
        $ret = null;
        foreach($this->keypoints() as $point) {
            if($ret === null) {
                $ret = $point["x"];
            } else {
                $ret = min($ret, $point["x"]);
            }
        }
        return $ret;
    }
    
    public function maxX() {
        $ret = null;
        foreach($this->keypoints() as $point) {
            if($ret === null) {
                $ret = $point["x"];
            } else {
                $ret = max($ret, $point["x"]);
            }
        }
        return $ret;
    }
    
    public function minY() {
        $ret = null;
        foreach($this->keypoints() as $point) {
            if($ret === null) {
                $ret = $point["y"];
            } else {
                $ret = min($ret, $point["y"]);
            }
        }
        return $ret;
    }
    
    public function maxY() {
        $ret = null;
        foreach($this->keypoints() as $point) {
            if($ret === null) {
                $ret = $point["y"];
            } else {
                $ret = max($ret, $point["y"]);
            }
        }
        return $ret;
    }
    
}
