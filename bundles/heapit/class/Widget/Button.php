<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class Button extends Widget {

    /**
    * Название виджета
    **/
    public function name() {
        return "Виджет кнопка";
    }
    
    /**
    * Рендер виджета
    **/
    public function execWidget() {
        $this->tag($this->param("submit") ? "button" : "a");
        if($this->param("submit")){
            $this->attr("type", "submit"); 
        }
        $this->addClass("button-2xgda31m91");
        if($this->param("class")){
            $this->addClass($this->param("class"));    
        }
        if($this->param("icon")){
            $this->addClass($this->param("icon"));
        }
        if($this->param("title")){
            $this->attr("title", $this->param("title"));
        }
        if($this->param("onclick")){
            $this->attr("onclick",  $this->param("onclick"));
        }
        if($this->param("style")){
            $this->attr("style", $this->param("style"));
        }
         
        if($this->param("href")){
           $this->attr("href", $this->param("href")); 
        }      
        \tmp::exec("/heapit/widgets/button", $this->params());   
    }  
    
}