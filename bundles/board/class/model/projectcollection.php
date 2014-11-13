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
    }
}
