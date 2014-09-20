<? 

namespace Infuso\Heapit\Handler;
use \Infuso\Core;


class Roles implements Core\Handler { 
    
    /**
    * @handler = infuso/deploy
    **/
    public function createRoles() {
         $role = \Infuso\User\Model\Role::create("heapit:manager", "Манагер Хэапита");                
    } 
    
}
