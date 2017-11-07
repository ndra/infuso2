<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class ImproveEditor extends \Infuso\CMS\Reflex\Editor{

    public function itemClass() {
        return Improve::inspector()->className();
    }

   /**
     * @reflex-root = on
     * @reflex-group = Мастер-классы
     **/
    public function all() {
        return Improve::all()->title("Ценности курсов")->param("sort", true);
    }
    
    public function metaEnabled() {
        return true;
    }
	
    public function events() {
		return array(
            $this->item()->subscribers()->title("Подписчики"),
        );
    }

} 