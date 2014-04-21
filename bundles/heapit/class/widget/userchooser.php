<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class UserChooser extends Widget {
    
    public function name() {
        return "Выбиралка юзера";
    }
    
    public function fieldName($name) {
        $this->param("name", $name);
        return $this;
    }
    
    public function value($value){
        $this->param("userId", $value);
        return $this;    
    }
     
    public function execWidget() {
        \tmp::exec("/heapit/widgets/userchooser",$this->params());          
    }    
}
