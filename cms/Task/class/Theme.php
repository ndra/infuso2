<?

namespace Infuso\Cms\Task;

/**
 * Стандартная тема модуля Task
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
        return "task";
    }

    public function autoload() {
        return true;
    }

    public function name() {
        return "task";
    }

}
