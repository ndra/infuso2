<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class OpenDateMemberEditor  extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return OpenDateMember::inspector()->className();
    }
    
	/**
     * @reflex-root = on
	 * @reflex-group = Заявки
     **/
    public function all() {
        return OpenDateMember::all()->title("Заявки на открытые даты");
    }
    
    public function listItemTemplate() {
        return app()->tm("/site/admin/open-date-member-list-item")
            ->param("editor", $this);
    }
    
}