<? 

namespace Infuso\Heapit\Handler;
use \Infuso\Core;


class Roles implements Core\Handler { 
    
    /**
    * @handler = infusoDeploy
    **/
    public function createRoles() {
         $role = \Infuso\User\Model\Role::create("heapit:manager", "Манагер Хэапита");                
    } 
    
}
