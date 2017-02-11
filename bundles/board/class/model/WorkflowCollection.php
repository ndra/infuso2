<?

namespace Infuso\Board\Model;

class WorkflowCollection extends \Infuso\Core\Behaviour {


    /**
     * Оставляет только видимые для текущего пользователя задачи
     **/
    public function visible() {
        if(app()->user()->checkAccess("board/editAnyTask")) {
        } elseif (app()->user()->hasRole("board/client")) {
           $projects = Access::all()
                ->eq("userId", app()->user()->id())
                ->distinct("projectId");
            $this->joinByField("taskId")->eq("Infuso\\Board\\Model\\Task.projectId", $projects);
        } else {
            $this->eq("id", 0);
        }
        return $this;
    }

}
