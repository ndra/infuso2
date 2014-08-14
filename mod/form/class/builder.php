<?

namespace Infuso\Form;
use \Infuso\Core;

/**
 * Формбилдер
 **/
class Builder extends Core\Component {

    private $form = null;

    public function __construct($form) {
        $this->form = $form;
    }    
    
    public function form() {
        return $this->form;
    }

    public function bind($selector) {
    
        \Infuso\Template\Lib::modjs();
        $js = self::inspector()->bundle()->path()."/res/js/form.js";
        app()->tm()->js($js);
        
        $form = get_class($this->form());  
        $form = addslashes($form);      
        
        app()->tm()->script("$(function() { form('$selector','$form') });");
    }

}
