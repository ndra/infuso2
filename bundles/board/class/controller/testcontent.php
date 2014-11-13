<?

namespace Infuso\Board\Controller;
use Infuso\Core;
use Infuso\Board\Model;

/**
 * Поведение для класса пользователя, добавляющее методы доски
 **/
class TestContent extends Core\Controller {

    public function indexTest() {
        return Core\Superadmin::check();
    }
    
	public function index() {
	    echo 1212;
	}
    
    public function index_import($p) {
    
        $id = (int) $p["id"];
    
        if($id == 0) {
            Model\Task::all()->delete();
            Model\Workflow::all()->delete();
            Model\Log::all()->delete();
        }
        
        for($j=0;$j<5;$j++) {
    
            $json = Core\File::http("http://ndra.ru/board_controller_export/index/id/{$id}")->data();
            $data = json_decode($json, 1);
            
            if($data["task"]["id"]) {
            
                $task = service("ar")
                    ->create(Model\Task::inspector()
                    ->className(), $data["task"]);
                
                foreach($data["workflow"] as $workflow) {
                    $task->workflow()->create($workflow);
                }
            
            }
            
            $id ++;
        
        }
        echo "<script>window.location.href='?id={$id}';</script>";
    
        var_export($data);
    
    }
    
    public function index_importEnv() {
    
        Model\Project::all()->delete();
        \Infuso\User\Model\User::all()->delete();
        \Infuso\User\Model\RoleAttached::all()->delete();
    
        $json = Core\File::http("http://ndra.ru/board_controller_export/env")->data();
        $data = json_decode($json, 1);
        
        foreach($data["project"] as $project) {
            service("ar")
                ->create(Model\Project::inspector()->className(), $project);
        }
        
        foreach($data["users"] as $userData) {
            $user = service("ar")
                ->create("Infuso\\User\\Model\\User", $userData);
                
            if($userData["board"]) {
                $user->addRole("boardUser");
            }
            
            $user->setVerification();
            
        }
        
        var_export($data);
    
    
    }
    
}
