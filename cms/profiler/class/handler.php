<?

namespace Infuso\CMS\Profiler;

class Handler extends \Infuso\Core\Controller implements \Infuso\Core\Handler {

    /**
     * @handler = infuso/beforeAction
     **/
    public function beforeAction() {
        \Infuso\Template\Lib::modJS();
        app()->tm()->js(self::inspector()->bundle()->path()."/res/js/profiler.js");
    }

}
