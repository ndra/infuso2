<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class BatteryCalculator extends Core\Controller {

    public function controller() {
        return "battery";
    }

	public function indexTest() {
	    return true;
	}
    
	public function postTest() {
	    return true;
	}
	
    public function index($p) {   
    
        $result = preg_match("%^(.*)-(\d+)s-(\d+)p%", $p["conf"], $matches);
        
        if($cont == "" || $result) { 
        
            $id = $matches[1];
            $serial = $matches[2] * 1 ?: 13;
            $parallel = $matches[3] * 1 ?: 10;
        
            $cell = \Infuso\Site\Model\BatteryCalculator\Cell::all()->eq("niceId", $id)->one();
            $work = !$p["work"];
            
            $battery = new \Infuso\Site\Battery($serial, $parallel, $cell->id());
            $battery->param("work", $work);
             
            app()->tm("/site/battery-calculator")
                ->param("battery", $battery)
                ->param("work", $work)
                ->param("bms", $p["bms"])
                ->param("charger", $p["charger"])
                ->exec();
            
        } else {
        
            app()->httpError(404);
        
        }
        
    }
    
    public function post_result($p) { 
    
        $cell = \Infuso\Site\Model\BatteryCalculator\Cell::all()->eq("niceId", $p["data"]["cell"])->one();
        $battery = new \Infuso\Site\Battery($p["data"]["serial"], $p["data"]["parallel"], $cell->id());
        
        $work = $p["data"]["work"];
        $battery->param("work", $work);
        
        $top = app()->tm("/site/battery-calculator/content/ajax-top")
            ->param("battery", $battery)
            ->getContentForAjax();
            
        $bottom = app()->tm("/site/battery-calculator/content/ajax-bottom")
            ->param("battery", $battery)
            ->getContentForAjax();

        $heading = app()->tm("/site/battery-calculator/content/ajax-heading")
            ->param("battery", $battery)
            ->getContentForAjax();

        return array(
            "top" => $top,
            "bottom" => $bottom,
            "heading" => $heading,
        );
    }

}
