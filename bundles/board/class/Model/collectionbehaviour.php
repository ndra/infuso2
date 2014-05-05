<?

namespace Infuso\Board\Model;

class CollectionBehaviour extends \Infuso\Core\Behaviour {

    /**
     * Фильтрует коллекцию по тэгу $tagId
     **/
    public function useTag($tagId) {
        $this->join("board_task_tag","board_task_tag.taskID = board_task.id")
            ->eq("board_task_tag.tagID", $tagId);
        return $this;
    }

    /**
     * Поиск по коллекции
     **/
    public function search($query) {
        $query2 = \util::str($query)->switchLayout();
        $this->joinByField("projectID");
        $this->like("text", $query)
            ->orr()->like("Infuso\\Board\\Model\\Project.title", $query)
            ->orr()->like("text", $query2)
            ->orr()->like("Infuso\\Board\\Model\\Project.title", $query2);
    }

    /**
     * Оставляет только видимые для текущего пользователя задачи
     **/
    public function visible() {
        $projects = Project::visible();
        $this->joinByField("projectID",$projects);
        return $this;
    }

}
