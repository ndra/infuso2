<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет с примерами батарей
 **/
class Batteries extends \Infuso\Template\Widget {

    public function name() {
        return "Выбиралка ячейки";
    }
    
    public function execWidget() {
    
        $batteries = array();
    
        if($this->param("cellId")) {
            $cell = \Infuso\Site\Model\BatteryCalculator\Cell::get($this->param("cellId"));
        
            // Создаем массив батарей
            $data = [
                [voltage => 36, kwh => .5],
                [voltage => 48, kwh => 1],
                [voltage => 72, kwh => 1.5],
                [voltage => 90, kwh => 2]];            
            
            foreach($data as $item) {               
                $serial = ceil($item["voltage"] / $cell->nominalVoltage());
                $parallel = ceil($item["kwh"] / ($cell->nominalCapacity() * $cell->nominalVoltage()) * 1000 / $serial);                
                $battery = new \Infuso\Site\Battery($serial, $parallel, $cell->id());
                $battery->setPower(278);
                $batteries[] = $battery;
            }
            
        } else {        
            foreach(\Infuso\Site\Model\BatteryCalculator\BatteryPreset::all()->limit(4) as $preset) {
                $battery = $preset->battery();
                $battery->setPower(278);
                $battery->param("title", $preset->title());
                $batteries[] = $battery;
            }
        }
    
        app()->tm("/site/widgets/batteries")
            ->params($this->params())
            ->param("batteries", $batteries)
            ->exec();
    }
    
    public function alias() {
        return "batteries";
    }

}
