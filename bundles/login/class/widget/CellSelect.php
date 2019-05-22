<?

namespace Infuso\Site\Widget;
use Infuso\Core;

/**
 * Виджет графика
 **/
class CellSelect extends \Infuso\Template\Widget {

    public function name() {
        return "Выбиралка ячейки";
    }
    
    public function execWidget() {
        app()->tm("/site/widgets/cell-select")
            ->params($this->params())
            ->exec();
    }
    
    public function alias() {
        return "cell-select";
    }

}
