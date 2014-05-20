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
    
    public function icon($icon) {    
        $icon = self::inspector()->bundle()->path()."/res/img/icons16/{$icon}.png";       
        $this->param("icon", $icon);
        return $this;
    }
    
    public function air() {
        $this->param("air", true);
        return $this;
    }
    
}
