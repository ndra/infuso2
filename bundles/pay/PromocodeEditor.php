<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class PromocodeEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Promocode::inspector()->className();
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Акции 
     **/
    public function all() {
        return Promocode::all()->title("Промо коды");
    }
	
	public function listItemTemplate() {
        return app()->tm("/site/admin/promocode-list-item")
            ->param("editor", $this);
    }

}