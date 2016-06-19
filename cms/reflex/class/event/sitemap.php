<?

namespace Infuso\Cms\Reflex\Event;
use Infuso\Core;

/**
 * Событие сбора данных для sitemap
 **/ 
class Sitemap extends Core\Event {

	private $collections = array();

	public function __construct() {
	    parent::__construct("reflex/sitemap");
	}

	public function addCollection($collection) {
	    $this->collections[] = $collection;
	}
	
	public function collections() { 	
        return $this->collections;	    
	}

}
