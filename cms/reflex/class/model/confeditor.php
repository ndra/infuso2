<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Редактор домена
 **/
class ConfEditor extends Reflex\Editor {

	public function itemClass() {
		return Conf::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Conf::all()
            ->param("sort", true)
            ->title("Настройки");
	}
    
    /**
	 * @reflex-child = on
	 **/
	public function conf() {
	    return $this->item()
            ->children()
            ->param("sort",true)
            ->title("Подразделы");
	}
    
    public function listItemTemplate() {
        return app()->tm("/reflex/conf/list-item")
            ->param("editor", $this);
    }
    
    /**
     * Возвращает шаблон формы редактирования элемента
     **/
    public function templateEditForm() {
		return app()
            ->tm("/reflex/conf/edit-form")
            ->param("editor",$this);
    }
    
    public function filters($collection) {
        $ret = array();
        if(!array_key_exists("parent", $collection->eqs("parent"))) {
            $ret["По группам"] = $collection->copy()->eq("parent", 0);
        }
        $ret["Все"] = $collection->copy();
        return $ret;
    }

}
