<?

namespace Infuso\Cms\UI\Widgets;

class Datepicker extends Input {

    public function name() {
        return "Датапыкер";
    }
    
    public function fastDayShifts($fastDayShifts){
        $this->param("fastDayShifts", $fastDayShifts);
        return $this;
    }
    
    public function clearButton() {
        $this->param("clearButton", true);
        return $this;    
    }
    
    public function execWidget() {

        $this->app()->tm()
            ->exec("/ui/widgets/datepicker",array (
                "widget" => $this,
            ));
    }

}
