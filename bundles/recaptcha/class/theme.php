<?

namespace Infuso\ReCaptcha;

/**
 * Стандартная тема для модуля ReCaptcha
 **/

class Theme extends \tmp_theme {

    public function path() {
        return self::inspector()->bundle()->path()."/theme/";
    }
    
    public function base() {
        return "recaptcha";
    }
    
    public function autoload() {
        return true;
    }
    
    public function name() {
        return "Стандартная тема recaptcha";
    }

}
