<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass as Masterclass;
use Infuso\Core;

class CorporateProgramsEditor extends \Infuso\CMS\Reflex\Editor{

    public function itemClass() {
        return CorporatePrograms::inspector()->className();
    }

   /**
     * @reflex-root = on
     * @reflex-group = Мастер-классы
     **/
    public function all() {
        return CorporatePrograms::all()->asc("priority")->param("sort",true)->title("Разделы корп. программ");
    }
    
	/**
     * @reflex-child = on
     **/
    public function masterclass() {
        return Masterclass::all()->eq("corporate_programs",$this->item()->id())->title("Мастер-классы"); 
    }

} 