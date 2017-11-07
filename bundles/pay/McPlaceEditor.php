<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class McPlaceEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return McPlace::inspector()->className();
    }
    
    public function metaEnabled() {
        return true;
    }

    /**
     * @reflex-root = on
	 * @reflex-group = Мастер-классы
     **/
    public function all() {
        return McPlace::all()->title("Места проведения");
    }
}