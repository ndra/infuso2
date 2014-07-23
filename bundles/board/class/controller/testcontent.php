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
        
        Model\Task::all()->delete();
        Model\Project::all()->delete();
        
        app()->tm()->header();
        
        $testProjects = self::inspector()->bundle()->path()->cd("testcontent/project.txt")->data();
        $testProjects = explode("\n", $testProjects);
        
        foreach($testProjects as $projectTitle) {
            Model\Project::all()->create(array(
                "title" => $projectTitle,
            ));
        }
        
        $testTasks = self::inspector()->bundle()->path()->cd("testcontent/task.txt")->data();
        $testTasks = explode("\n", $testTasks);     
           
        for($i=0;$i<5;$i++) {
            foreach($testTasks as $taskText) {
                Model\Task::all()->create(array(
                    "text" => $taskText,
                    "projectId" => Model\Project::all()->rand()->id(),
                ));
            }
        }
        
        app()->tm()->footer();
        
        
        
        
    }
    
}
