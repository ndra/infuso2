<?

namespace Infuso\Poll\Model;

class VoteEditor extends \Infuso\Cms\Reflex\Editor {

    public function itemClass() {
        return Poll::inspector()->className();
    }
    
    /**
     * @reflex-root = on
     * @reflex-group = Опрос    
     **/         
    public function all() {
        return Poll::all()
            ->title("Опросы");
    }
    
    /**
     * @reflex-child = on
     **/         
    public function options() {
        return $this->item()
            ->options()
            ->title("Варианты ответа");
    }
    
    /**
     * @reflex-child = on
     **/         
    public function answers() {
        return $this->item()
            ->answers()
            ->title("Ответы");
    }
    
    public function listItemTemplate() {
        return app()
            ->tm("/poll/admin/list-item")
            ->param("poll", $this->item());
    }
    
    public function filters($collection) {
        $ret = array();
        $ret["Все"] = $collection->copy();
        $ret["Активные"] = $collection->copy()->eq("active", 1);
        $ret["Неактивные"] = $collection->copy()->eq("active", 0);
        return $ret;
    }
    
}
