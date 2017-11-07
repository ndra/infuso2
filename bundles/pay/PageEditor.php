<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class PageEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Page::inspector()->className();
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Новое меню 
     **/
    public function all() {
        return Page::all()->title("Специальные предложения");
    }
    
    public function metaEnabled() {
        return true;
    }
}