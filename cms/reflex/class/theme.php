<?

namespace Infuso\Cms\Reflex;

/**
 * Стандартная тема модуля reflex
 **/

class Theme extends \Infuso\Template\Theme {

    /**
     * @return Приоритет темы =-1
     **/
    public function priority() {
        return -1;
    }

    public function path() {
        return self::inspector()->bundle()->path()."/theme/";
    }

    public function base() {
        return "reflex";
    }

    public function autoload() {
        return true;
    }

    public function name() {
        return "reflex";
    }

}
