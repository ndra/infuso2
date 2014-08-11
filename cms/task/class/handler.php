<?

namespace Infuso\Cms\Task;
use Infuso\Core;

class Handler implements Core\Handler {

    /**
     * @handler = infuso/cron
     **/         
    public function onCron() {
        service("task")->runTasks();     
    }
    
	/**
     * @handler = infusoDeploy
     * @handlerPriority = -1;
     **/
    public function onDeployStart() {
        service("cache")->set("task-origin-xIIqYM4rBT", \util::id());
    }
    
    public function getOrigin() {
        return service("cache")->get("task-origin-xIIqYM4rBT");
    }
    
    /**
     * Грохает задачи кототыре были добавлены в предущий infusoDeploy
     * @handler = infusoDeploy
     * @handlerPriority = 1000;
    **/
    public function onDeployEnd() {
    
        \Infuso\Cms\Task\Task::all()
            ->eq("completed",0)
            ->neq("origin","")
            ->neq("origin",self::getOrigin())
            ->data("completed",1); 
                                      
        service("cache")->set("task-origin-xIIqYM4rBT", "");
    }
    
}
