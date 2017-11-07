<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class PageMenuEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return PageMenu::inspector()->className();
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Новое меню 
     **/
    public function all() {
        return PageMenu::all()
            ->eq("parent",0)
			->asc("priority")
			->param("sort", true)->title("Cтраницы меню");
    }
    
    public function metaEnabled() {
        return true;
    }
    
    /**
	 * @reflex-child = on
	 **/
	public function children() {
            return $this->item()->childrenPages()->param("title","Дочерние страницы");
    } 

}