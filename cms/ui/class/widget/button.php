<?

namespace Infuso\Cms\UI\Widgets;

class Button extends \Infuso\Template\Helper {

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

        \tmp::exec("/ui/widgets/button", array(
            "widget" => $this,
        ));
    }  
    
    public function text($text) {
        $this->param("text", $text);
        return $this;
    }
    
}
