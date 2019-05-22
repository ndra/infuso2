<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет графика
 **/
class CollapserHead extends \Infuso\Template\Helper {

    public function __construct() {
        parent::__construct();
        $this->id(\Infuso\Util\Util::id());
    }

    public function name() {
        return "Коллапсер (Сворачивалка)";
    }
    
    public function execWidget() {
        app()->tm("/site/widgets/collapser-head")
            ->params($this->params())
            ->param("widget", $this)
            ->exec();
    }
    
    public function id($id = null) {
        if(func_num_args() == 0) {
            return $this->param("id");
        } elseif (func_num_args() == 1) {
            return $this->param("id", $id);
        }
    }
    
    public function alias() {
        return "collapser-head";
    }

}
