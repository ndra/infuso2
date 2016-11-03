<?

namespace Infuso\CMS\Filter;
use Infuso\Core;

/**
 * Виджет фильтра
 **/
class Pager extends \Infuso\Template\Widget {

    public function name() {
        return "Пейджер";
    }
    
    public function alias() {
        return "pager";
    }

    public function collection($collection) {
        if(func_num_args() == 0) {
            return $this->param("collection");
        } elseif(func_num_args() == 1) {
            $this->param("collection", $collection);
            return $this;
        }
    } 
    
    public function execWidget() {
        app()->tm("/cms/filter/widget/pager")
            ->param("collection", $this->param("collection"))
            ->exec();
    }

}
