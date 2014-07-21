<? 

namespace Infuso\Cms\UI\Widgets;

class Autocomplete extends Input {
    
    public function name() {
        return "Автокомплит поле с ajax";
    }
    
    public function cmd($cmd){
        $this->param("cmd", $cmd);
        return $this;    
    }
    
    public function cmdParams($params){
        $str = "";
        foreach($params as $key=>$value){
            $str .= "$key:$value;";        
        }
        $this->param("cmdParams", $str);
        return $this;
    }
    
    public function title($title){
        $this->param("title", $title);
        return $this;        
    }
    
    
    public function execWidget() { 
		 app()->tm("/ui/widgets/autocomplete")->param("widget",$this)->exec();
    }
        
}