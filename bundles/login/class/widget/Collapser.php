<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет графика
 **/
class Collapser extends \Infuso\Template\Helper {

    private $head;

    public function __construct() {
        parent::__construct();
        $this->id(\Infuso\Util\Util::id());             
    }

    public function name() {
        return "Коллапсер";
    }
    
    public function execWidget() {
        app()->tm("/site/widgets/collapser")
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
    
    public function keep() {
        $this->param("keep", true);
        return $this;
    }
    
    public function head() {
        if(!$this->head) {
            $this->head = new \Infuso\Site\Widget\CollapserHead();
            $this->head->param("id", $this->id());
        }
        return $this->head;
    }
    
    public function alias() {
        return "collapser";
    }

}
