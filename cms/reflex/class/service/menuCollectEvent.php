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
	
	    if(array_key_exists("template",$params)) {
	        $item = \tmp::get($params["template"]);
	        if(is_array($params["templateParams"])) {
	            $item->params($params["templateParams"]);
	        }
			$this->menuItems[] = $item;
	    }
	    
	}
	
	public function items() {
	    return $this->menuItems;
	}

}
