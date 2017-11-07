<?

namespace Infuso\Site\Model;
use Infuso\Core;

class SpeakerEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Speaker::inspector()->className();
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Преподаватели 
     **/
    public function all() {
        return Speaker::all()->title("Преподаватели");
    }
	
	/**
     * @reflex-child = on
     **/
    public function questions() {
        return $this->item()->questions()->title("Вопросы преподавателю");
    }
	
	/**
     * @reflex-child = on
     **/
    public function masterclasses() {
        return $this->item()->masterclasses()->title("Мастерклассы");
    }
	
	/**
     * @reflex-child = on
     **/
    public function members_news() {
        return $this->item()->members_news()->title("Подписчики");
    }
	
	/**
     * @reflex-child = on
     **/
    public function allMaterials() {
        return $this->item()->materials()->title("Полезные материалы");
    }
    
    public function metaEnabled() {
        return true;
    }

}