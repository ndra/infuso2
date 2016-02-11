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

        app()->tm("/infuso/profiler/widget")->inc();
        app()->tm("/infuso/profiler/widget/main")->inc();
        app()->tm("/infuso/profiler/widget/milestones")->inc();
        \Infuso\Template\Lib::jq();

    }

    public static function showProfiler() {
    
        if(!\Infuso\Core\Superadmin::check()) {
            return;
        }

		\Infuso\Core\Profiler::stop();
        app()->tm("/infuso/profiler/widget")->exec();

    }

}
