<?

namespace Infuso\Plugins;
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
        \tmp::js(\mod::service("classmap")->getClassBundle(get_class())->path()."/res/menu/menu.js");
        \tmp::head("<style>{$this->submenu} {display:none}</style>");
        $p = json_encode($this->params());
        \tmp::head("<script>$(function() { ndra.menu('{$this->menu}','{$this->submenu}',$p) })</script>");
    }

}
