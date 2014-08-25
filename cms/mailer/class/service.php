<?

namespace Infuso\CMS\Mailer;
use \Infuso\Core;

class Service extends Core\Service {
 
    public function defaultService() {
        return "mail";
    }
    
    public function create($params = array()) {  
        return service("ar")->create(Model\Mail::inspector()->classname(), $params);
    }    

}
