<?

namespace Infuso\Cms\Heartbeat;
use Infuso\Core;

class Telemetry extends Core\Controller {

    public function controller() {
        return "heartbeat-telemetry";
    }

	public function indexTest() {
	    return true;
	}
	
	public function index() {

        $error = false;
        $warning = false; 
        
        $event = new \Infuso\Cms\Heartbeat\Event();
        $event->fire();   
        
        foreach($event->getMessages() as $message) {              
            if($message["type"] == \Infuso\Cms\Heartbeat\Event::TYPE_ERROR) {
                $error = true;
            }             
            if($message["type"] == \Infuso\Cms\Heartbeat\Event::TYPE_WARNING) {
                $warning = true;
            }            
        }
        
        $status = "ok";
        if($warning) {
            $status = "warning";
        }
        if($error) {
            $status = "error";
        }
        
        $data = array(
            "health" => $status,
        );
        
        echo json_encode($data);
    
		
	}

}
