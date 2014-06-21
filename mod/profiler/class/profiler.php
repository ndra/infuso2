<?

namespace Infuso\Profiler;

class Widget extends \Infuso\Core\Component {

    public function profiler() {

        $fn = \tmp_delayed::add(array(
            "class" => self::inspector()->className(),
            "method" => "showProfiler",
            "priority" => 100000
        ));
        echo $fn;

        \tmp::get("/infuso/profiler/widget")->inc();
        \tmp::get("/infuso/profiler/widget/main")->inc();
        \tmp::get("/infuso/profiler/widget/milestones")->inc();
        \tmp::jq();

    }

    public static function showProfiler() {

        if(!\Infuso\Core\Superadmin::check()) {
            return;
        }

		\Infuso\Core\Profiler::stop();
        \tmp::exec("/infuso/profiler/widget");

    }

}
