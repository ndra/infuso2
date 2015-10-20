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
        return Poll::allEvenHidden()
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
    
}
