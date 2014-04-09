<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class Datepicker extends Widget {
    
    public function name() {
        return "Датапикер";
    }
    
    public function fieldName($fieldName) {
        $this->param("fieldName", $fieldName);
        return $this;
    }
    
    public function value($value){
        $this->param("date", $value);
        return $this;    
    }
     
    public function execWidget() {
        \tmp::exec("/heapit/widgets/datepicker",$this->params());          
    }    
}