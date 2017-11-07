<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class Eventeditor  extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Event::inspector()->className();
    }

    public function all() {
        return Event::all();
    }
	
	public function listItemTemplate() {
        return app()->tm("/site/admin/event-list-item")
            ->param("editor", $this);
    }
    
	public function _layout() {
	    return array(
			"form",
			"collection:ticketTypes",
		);
	}
    
    /**
     * @reflex-child = on
     **/
    public function openDateMembers() {
        return $this->item()->openDateMembers()->title("Заявки на открытую дату");
    }
    
    /**
     * @reflex-child = on
     **/
    public function ticketTypes() {
        return $this->item()->ticketTypes()->title("Доп. типы билетов");
    }
    
    public function index_promocodes($p) {         
        $class = get_called_class();
        $editor = new $class($p["id"]);
        app()->tm("/site/admin/event-promocode-manage")
            ->param("editor", $editor)
            ->exec();
    }
    
    public function menu() {
        $menu = parent::menu();
        $menu[] = [
            "title" => "Управление промо-кодами",
            "href" => new Core\Action(get_class(), "promoCodes", ["id" => $this->itemId()]),
        ];
        return $menu;
    }
    
}