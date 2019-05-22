<?

namespace Infuso\Site;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Battery extends \Infuso\Core\Component {

    private $serial;
    private $parallel;
    private $cell;
    private $currency;
    
    public function initialParams() {
        return array(
            "work" => true,
        );
    }

    public function __construct($serial, $parallel, $cellId) {    
        $this->serial = $serial;
        $this->parallel = $parallel;
        $this->cell = \Infuso\Site\Model\BatteryCalculator\Cell::get($cellId);     
          
    } 
    
    public function isError() {
        return !!$this->errorText();
    }
    
    public function errorText() {
    
        if(!is_numeric($this->serial) || (int) $this->serial != (double) $this->serial) {
            return "Количество ячеек последовательно должно быть целым числом";
        }
        
        if($this->serial <= 0) {
            return "Количество ячеек последовательно должно быть больше нуля";
        }
        
        if(!is_numeric($this->parallel) || (int) $this->parallel != (double) $this->parallel) {
            return "Количество ячеек параллельно должно быть целым числом";
        }
        
        if($this->parallel <= 0) {
            return "Количество ячеек параллельно должно быть больше нуля";
        }
        
        return null;
    
    }
    
    public function serial() {
        return $this->serial;
    }

    public function parallel() {
        return $this->parallel;
    }
    
    public function cell() {
        return $this->cell;
    }
    
    public function work() {
        return $this->param("work");
    }
    
    public function count() {
        return $this->serial() * $this->parallel();
    }
    
    /**
     * Возвращает вес батареи, кг
     **/
    public function weight() {
        return $this->cell()->assemblyWeight() * $this->count() / 1000;
    }
    
    public function nominalVoltage() {
        return $this->cell->nominalVoltage() * $this->serial();
    }
    
    /**
     * Возвращает максимальный постоянный ток разряда, А
     **/
    public function maxContinuousCurrentDischarge() {
        return $this->cell->data("continuousCurrentDischarge") * $this->parallel();
    }
    
    /**
     * Возвращает максимальную постоянную мощность, Вт
     * мощность расчитывается как максимальный ток, умноженный на напряжение батареи при этом токе
     **/
    public function maxContinuousPower() {
        $current = $this->maxContinuousCurrentDischarge();
        $this->setCurrent($current);
        return $this->maxContinuousCurrentDischarge() * $this->voltage();
    }
    
    /**
     * Возвращает емкость батареи при разряде током заданной силы
     **/
    public function capacity() {
        return $this->cell()->capacityAh($this->cellCurrent()) * $this->cell()->voltage($this->cellCurrent()) * $this->count();
    }
    
    public function capacityAH() {
        return $this->cell()->capacityAh($this->cellCurrent()) * $this->parallel();
    }
    
    public function nominalCapacity() {
        return $this->cell()->nominalCapacity() * $this->cell()->nominalVoltage() * $this->count();
    }
    
    public function price() {
    
        $cellPrice = $this->work() ?
            $this->cell()->priceFinal($this->count())->usd() :
            $this->cell()->priceSelling($this->count())->usd();
            
    
        return new Price($cellPrice * $this->count());
    }
    
    /**
     * Устанавливает ток разряда
     **/
    public function setCurrent($current) {
        $this->current = $current;
    }
    
    public function current() {
        return $this->current;
    }
    
    public function cellCurrent() {
        return $this->current() / $this->parallel();
    }
    
    public function rate() {
        return $this->current() / $this->cell()->nominalCapacity() / $this->parallel();
    }
    
    /**
     * Устанавливает ток разряда в зависимости от мощности
     * $power - мощность в ваттах
     **/
    public function setPower($power) {
        
        $values = array();         
        $a = 0;
        $b = $this->cell()->data("continuousCurrentDischarge") * 2;
         
        $process = function() use (&$a, &$b, &$values, $power) {
        
            $values = array();

            for($i = 0; $i < 10; $i++) {
                $k = $i / 10;
                $current = $a * (1 - $k) + $b * $k;
                $voltage = $this->cell()->voltage($current);
                $values[] = array (
                    "c" => $current,
                    "p" => $current * $voltage * $this->count(),
                );
            }
            
            uasort($values, function($a,$b) use($power) {         
                $d = abs($a["p"] - $power) - abs($b["p"] - $power);
                return $d == 0 ? 0 : $d / abs($d);         
            });
            
            $values = array_values($values);
            
            $a = $values[0]["c"];
            $b = $values[1]["c"];
        
        };
        
        for($i = 0; $i <= 10; $i ++) {
            $process();
        }
        
        $this->setCurrent($values[0]["c"] * $this->parallel());
            
    }
    
    /**
     * Возвращает мощность при заданном токе разряда
     **/
    public function power() {
        return $this->current() * $this->voltage();
    }  
    
    /**
     * Возвращает напряжение при заданном токе разряда
     **/
    public function voltage() {
        return $this->cellVoltage() * $this->serial();
    } 
    
    public function cellVoltage() {
        return $this->cell()->voltage($this->cellCurrent());
    } 
    
    public function cycles() {
        return $this->cell()->cycles($this->cellCurrent());
    } 
    
    /**
     * Возвращает нагрев батареи, Вт
     **/
    public function heat() {
        return pow($this->cellCurrent(), 2) * $this->cell()->data("internalResistance") / 1000 * $this->count();
    }
    
    /**
     * Возвращат полный пробег на одной зараядке
     **/
    public function range($speed) {     
        if($this->power() == 0) {
            return null;
        }
        $time = $this->capacity() / $this->power();
        return $time * $speed;     
    }
    
    /**
     * Возвращат полный пробег до потери 70% емкости
     **/
    public function totalRange($speed) {     
        return $this->range($speed) * $this->cycles() * (1 + 0.7) / 2;    
    }
    
    public function pricePer100km($speed) {
        $totalRange = $this->totalRange($speed);
        if(!$totalRange) {
            return new Price(0);
        }
        return new Price(($this->price()->usd() / $totalRange) * 100); 
    }
    
    public function url() {
        return "/battery/".$this->cell()->data("niceId")."-".$this->serial()."s-".$this->parallel()."p";
    }
    
    public function title() {
        return $this->param("title");
    }
    
}
