<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет батареи
 **/
class Battery extends \Infuso\Template\Widget {

    public function name() {
        return "Батарея";
    }
    
    public function execWidget() {
    
        $battery = new \Infuso\Site\Battery(            
            $this->param("serial"),
            $this->param("parallel"),
            $this->param("cell"));
            
        $battery->param("title", $this->param("title"));         
        $battery->setPower(278);
        
        app()->tm("/site/widgets/battery")
            ->params($this->params())
            ->param("battery", $battery)
            ->exec();
    }
    
    public function color($index) {
        switch($index) {
            default:
            case 1:
                $this->param("color", "#39762f");                
                break;        
            case 2:
                $this->param("color", "#33678a");
                break;
            case 3:
                $this->param("color", "#a51f22");
                break;
            case 4:
                $this->param("color", "#d17715");
                break;
        }
        return $this;
    }
    
    public function alias() {
        return "battery";
    }

}
