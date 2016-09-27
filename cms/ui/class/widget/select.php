<?

namespace Infuso\Cms\UI\Widgets;

class Select extends Input {

    public function name() {
        return "Селект";
    }
    
    public function values($values) {
        $this->param("values", $values);
        return $this;
    }

    public function execWidget() {
        app()->tm()
            ->exec("/ui/widgets/select",array (
                "widget" => $this,
            ));
    }

}
