<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass as Masterclass;
use Infuso\Core;

class CategoryEditor extends \Infuso\CMS\Reflex\Editor{

    public function itemClass() {
        return Category::inspector()->className();
    }

   /**
     * @reflex-root = on
     * @reflex-group = Мастер-классы
     **/
    public function all() {
        return Category::all()->title("Рубрики");
    }
    
    /**
     * @reflex-group = Мастер-классы
     **/
    public function speakers() {
        return Category::all()->asc("priority_speaker")->param("sort",true)->title("Сортировка рубрик для страницы спикеров");
    }
	
	/**
     * @reflex-child = on
     **/
    public function masterclass() {
        return Masterclass::all()->eq("category",$this->item()->id())->title("Мастер-классы"); 
    }
	
    public function subscribers() {
        return $this->item()->subscribers()->title("Подписчики");
    }
	
    public function metaEnabled() {
        return true;
    }    

} 