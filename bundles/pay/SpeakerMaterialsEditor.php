<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class SpeakerMaterialsEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return SpeakerMaterials::inspector()->className();
    }

    /**
	 * @reflex-group = Преподаватели  
     **/
    public function all() {
        return SpeakerMaterials::all()->title("Полезные материалы");
    }
}