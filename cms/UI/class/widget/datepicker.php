<?

namespace Infuso\Cms\UI\Widgets;

class Datepicker extends Input {

    public function name() {
        return "Датапыкер";
    }

    public function execWidget() {

        $this->app()->tmp()
            ->exec("/ui/widgets/datepicker",array (
                "widget" => $this,
            ));
    }

}
