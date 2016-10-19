<?

namespace Infuso\Cms\Reflex\Handler;
use Infuso\Cms\Reflex\Model;  
use Infuso\Core;

class URLMeta implements Core\Handler {
	
	
	/**
	 * @handler = ActiveRecord/AfterStore
	 **/
	public function onStore($event) {        
        
        $item = $event->param("item");
        if(is_a($item, "infuso\\cms\\reflex\\autoroute")) {
            $url = $item->generateURL();
            $item->plugin("route")->setURLAuto($url);
        }
        
	}
    
}
