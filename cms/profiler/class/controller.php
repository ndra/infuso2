<?

namespace Infuso\CMS\Profiler;

class Controller extends \Infuso\Core\Controller {

    public function postTest() {
        return true;
    }

    public function post_info($p) {
        return app()->tm("/cms/profiler/profiler")
            ->getContentForAjax();
    }

}
