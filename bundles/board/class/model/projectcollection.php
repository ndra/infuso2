<?

namespace Infuso\Board\Model;

class ProjectCollection extends \Infuso\Core\Behaviour {

    /**
     * Оставляет только видимые для текущего пользователя проекты
     **/
    public function visible() {
        if(app()->user()->checkAccess("board/viewAllProjects")) {
        } elseif (app()->user()->checkAccess("board/viewProjectsByAccess")) {
           $projects = Access::all()
                ->eq("userId", app()->user()->id())
                ->distinct("projectId");
            $this->eq("id", $projects);
        } else {
            $this->eq("id", 0);
        }
        return $this;
    }
    
    /**
     * Сортирует коллекцию, так чтобы проекты, в которых недавно создавались задачи
     * были на первом месте
     **/
    public function lastUsed() {
        $userId = app()->user()->id(); 
        $this->leftJoin("Infuso\\Board\\Model\\Task","`Infuso\\Board\\Model\\Task`.`projectId` = `Infuso\\Board\\Model\\Project`.`id` and `Infuso\\Board\\Model\\Task`.`creator`={$userId}")
        ->groupBy("Infuso\\Board\\Model\\Project.id")
        ->desc("max(Infuso\\Board\\Model\\Task.created)");    
        return $this;
    }
    
    /**
     * Поиск по коллекции
     **/
    public function search($query) {
        $query2 = \util::str($query)->switchLayout();
        $this->like("title", $query)
            ->orr()->like("title", $query2);
        return $this;
    }
}
