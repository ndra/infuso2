<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;

/**
 * Служба лога
 **/ 
class menuCollectEvent extends Core\Event {

	private $menuItems = array();

	public function __construct() {
	    parent::__construct("reflexMenu");
	}

	public function add($params) {
	    $this->menuItems[] = $params;
	}
	
	public function items($tab) {
	
	    $ret = array();

		foreach($this->menuItems as $params) {
		    if($params["tab"] == $tab) {
				if(array_key_exists("template", $params)) {
			        $item = app()->tm($params["template"]);
			        if(is_array($params["templateParams"])) {
			            $item->params($params["templateParams"]);
			        }
					$ret[] = $item;
			    }
		    }
	    }
	    
	    return $ret;
	    
	}

}
