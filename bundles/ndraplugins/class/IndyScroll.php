<?
 /**
 * умный Скролл-бар
 **/
namespace NDRA\Plugins;
use \Infuso\Core;

class IndyScroll extends Core\Component {

    private $blocks,$container;

    public function create($a,$b) {
        return new self($a,$b);
    }

    public function __construct($blocks=null,$container=null) {
        $this->blocks= $blocks;
        $this->container = $container;
    }

    /**
     * Подключаем скролл
     **/
    public function exec() {
        \Infuso\Template\Lib::jq();
        app()->tm()->js(service("classmap")->getClassBundle(get_class())->path()."/res/js/indyscroll.js");
        $params = json_encode($this->params());
		app()->tm()->head("<script>$(function(){ndra.indyScroll({ blocks: '{$this->blocks}', container: '{$this->container}',$param});});</script>");
    }

}
