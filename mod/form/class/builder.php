<?

namespace Infuso\Form;
use \Infuso\Core;

/**
 * Формбилдер
 **/
class Builder extends Core\Component {

    public function bind($selector) {       \
        $js = self::inspector()->bundle()->path()."/res/js/form.js";
        app()->tm()->js($js);
    }

}
