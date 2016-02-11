<?

namespace Infuso\CMS\Profiler;

class Controller extends \Infuso\Core\Controller {

    public function postTest() {
        return \Infuso\Core\Superadmin::check();
    }

    public function post_info($p) {
        return app()
            ->tm("/cms/profiler/profiler")
            ->param("id", $p["id"])
            ->param("data", service("cache")->get($p["id"]))
            ->getContentForAjax();
    }
    
    public function post_short($p) {
        return app()
            ->tm("/cms/profiler/profiler-short")
            ->param("id", $p["id"])
            ->param("data", service("cache")->get($p["id"]))
            ->getContentForAjax();
    }

}
