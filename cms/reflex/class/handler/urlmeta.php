<?

namespace Infuso\Cms\Reflex\Handler;
use Infuso\Cms\Reflex\Model;  
use Infuso\Core;

class URLMeta implements Core\Handler {
	
	
	/**
	 * @handler = ActiveRecord/AfterStore
	 **/
	public function onStore($event) {        
        
      //  app()->msg($event->params());
        
	}
    
}
