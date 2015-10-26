<?

namespace NDRA\Plugins;
use \Infuso\Core;

class Menu extends Core\Component {

    private $menu,$submenu;

    public function create($a,$b) {
        return new self($a,$b);
    }

    public function __construct($menu=null,$submenu=null) {
        $this->menu = $menu;
        $this->submenu = $submenu;
    }

    /**
     * Устанавливает смещение субменю относительно пункта меню
     **/
    public function offset($o) {
        $this->param("offset",$o);
            return $this;
    }

    /**
     * Подключает меню
     **/
    public function exec() {
        \Infuso\Template\Lib::jq();
        app()->tm()->js(service("classmap")->getClassBundle(get_class())->path()."/res/menu/menu.js");
        app()->tm()->head("<style>{$this->submenu} {display:none}</style>");
        $p = json_encode($this->params());
        app()->tm()->head("<script>$(function() { ndra.menu('{$this->menu}','{$this->submenu}',$p) })</script>");
    }

}
