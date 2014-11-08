<? 

namespace Infuso\Cms\UI\Widgets;

class Combo extends Input {
    
    public function name() {
        return "Комбобокс";
    }
    
    public function callParams($params) {
        $this->param("call", $params);
        return $this;    
    }
    
    public function title($title){
        $this->param("title", $title);
        return $this;        
    }      
    
    public function execWidget() { 
		 app()->tm("/ui/widgets/combo")
            ->param("widget",$this)->exec();
    }
        
}