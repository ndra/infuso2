<?

namespace Infuso\Site\Model;
use Infuso\Core;

class Masterclasseditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Masterclass::inspector()->className();
    }

	/**
     * @reflex-root = on
     * @reflex-group = Мастер-классы 
     **/
    public function all() {
        return Masterclass::all()->title("Мастер-классы");
    }
    
    public function metaEnabled() {
        return true;
    }

    /**
     * @reflex-child = on
     **/
    public function schedule() {
        return Event::all()
            ->eq("pid", $this->item()->id())
            ->asc("open_date")
            ->desc("date_start", true)
            ->title("Расписание");
    }
	
	/**
     * @reflex-child = on
     **/
    public function reviews() {
        return $this->item()->reviews()->title("Отзывы");
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
	public function gallery() {
		return $this->item()
            ->gallery()
			->param("title","Фотогалерея");
	}	
   
}