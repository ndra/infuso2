<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class Datepicker extends Widget {
    
    public function name() {
        return "Датапикер";
    }
     
    public function execWidget() {
        \tmp::exec("/heapit/widgets/datepicker",$this->params());          
    }    
}