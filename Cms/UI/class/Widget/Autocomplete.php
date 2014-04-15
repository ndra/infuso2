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
    
    
    public function title($title){
        $this->param("title", $title);
        return $this;        
    }
    
    public function execWidget() {
        \tmp::exec("/ui/widgets/autocomplete", array (
            "widget" => $this,
         ));    
    }
        
}