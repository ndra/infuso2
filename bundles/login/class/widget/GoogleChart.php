<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет графика
 **/
class GoogleChart extends \Infuso\Template\Widget {

    private $values = array();
    private $options = array();

    public function name() {
        return "Гугл-чарт";
    }
    
    public function execWidget() {
        $this->param("values", $this->values);
        $this->param("options", $this->options);
        app()->tm("/site/widgets/google-chart")
            ->params($this->params())
            ->exec();
    }
    
    public function alias() {
        return "googlechart";
    }
    
    public function options($key, $val) {
        $this->options[$key] = $val;
    }
    
    public function values($key, $val) {
        $this->values[] = [$key, $val];
    }
    
    public function value($key, $val) {
        $this->values[] = [$key, $val];
    }

}
