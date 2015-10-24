<?

namespace Infuso\Cms\Log;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;


/**
 * Редактор домена
 **/
class LogEditor extends Reflex\Editor {

	public function itemClass() {
		return Log::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Log::all()->title("Лог");
	}
	
	public function listItemTemplate() {
	    return app()->tm("/log/list-item")->param("editor", $this);
	}
    
    public function filters($collection) {
        $ret = array();
        $ret["Все"] = $collection->copy();
        $ret["Ошибки"] = $collection->copy()->eq("type","error");
        $ret["Задачи"] = $collection->copy()->eq("type","task");
        $ret["Крон"] = $collection->copy()->eq("type","cron");
        return $ret;
    }
    

}
