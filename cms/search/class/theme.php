<?

namespace Infuso\Cms\Search;

/**
 * Стандартная тема модуля search
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
        return "search";
    }

    public function autoload() {
        return true;
    }

    public function name() {
        return "search";
    }

}
