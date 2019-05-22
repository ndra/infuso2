<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class CellEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Cell::inspector()->className();
    }
    
    public function index_prices($p) {
        $editor = new self($p["id"]);
        app()->tm("/site/admin/cell-prices")
            ->param("editor", $editor)
            ->exec();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Cell::all()
            ->title("Ячейки");
    }

    /**
     * @reflex-child = on
     **/         
    public function discharge() {
        return $this->item()
            ->discharge()
            ->title("Режимы разряда");
    }
    
    public function title() {
        return $this->item()->vendor()->title()." ".$this->item()->title();
    }
    
    public function filters($collection) {
        return array(
            "Опубликовано" => $collection->copy()->eq("publish", 1),
            "Не опубликовано" => $collection->copy()->eq("publish", 0),
        );
    }
    
    public function menu() {
        $ret = parent::menu();
        $ret[] = array(
            "title" => "Цены",
            "href" => new \Infuso\Core\Action(get_class(), "prices", array("id" => $this->itemId())),
        );
        return $ret;
    }
    
    public function metaEnabled() {
        return true;
    }
    
}

