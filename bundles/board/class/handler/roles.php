<? 

namespace Infuso\Board\Handler;
use \Infuso\Core;


class Roles implements Core\Handler { 
    
    /**
    * @handler = infusoDeploy
    **/
    public function createRoles() {
        $role = \Infuso\User\Model\Role::create("boardUser", "Пользователь доски");  
         
        $o = \Infuso\User\Model\Operation::create("board:viewAllProjects");
        $o->appendTo("boardUser");
        
        \Infuso\User\Model\Operation::create("board/showReportUsers","Просмотр отчета по пользователям")
            ->appendTo("boardUser");              
    } 
    
}
