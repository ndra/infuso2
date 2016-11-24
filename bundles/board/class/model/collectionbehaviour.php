<?

namespace Infuso\Board\Model;

class CollectionBehaviour extends \Infuso\Core\Behaviour {

    /**
     * Поиск по коллекции
     **/
    public function search($query) {
    
        if((string)($query * 1) == $query) {
            $this->eq("id", $query);
            return $this;
        }
    
        $query2 = \util::str($query)->switchLayout();
        $this->joinByField("projectId");
        $this->like("text", $query)
            ->orr()->like("Infuso\\Board\\Model\\Project.title", $query)
            ->orr()->like("text", $query2)
            ->orr()->like("Infuso\\Board\\Model\\Project.title", $query2);
        return $this;
    }

    /**
     * Оставляет только видимые для текущего пользователя задачи
     **/
    public function visible() {
        if(app()->user()->checkAccess("board/editAnyTask")) {
        } elseif (app()->user()->hasRole("board/client")) {
           $projects = Access::all()
                ->eq("userId", app()->user()->id())
                ->distinct("projectId");
            $this->eq("projectId", $projects);
        } else {
            $this->eq("id", 0);
        }
        return $this;
    }
    
    /**
     * Показвает задачи с моим участием, свежие - на первом месте
     **/         
    public function withMyParticipation() {
        $this->join(Workflow::inspector()->className(), "`infuso\\board\\model\\workflow`.`taskId` = `infuso\\board\\model\\task`.`id`" );
        $this->eq("infuso\\board\\model\\workflow.userId", app()->user()->id());
        $this->groupBy("id");
        return $this;
    }

}
