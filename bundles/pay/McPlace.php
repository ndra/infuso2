<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass  as Masterclass;
use Infuso\Core;

class McPlace extends  \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => 'mcPlace',
            'fields' => array (
                array(
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array(
                    'name' => 'mc',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '2',
                    'label' => 'Мастер-класс',
                    'class' => Masterclass::inspector()->className(),
                    'indexEnabled' => 1,
                ),array(
                    'name' => 'address_title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: название',
                ),array(
                    'name' => 'address_text',
                    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
                    'editable' => '1',
                    'label' => 'Место проведения: описание',
                ),array(
                    'name' => 'address_country',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: страна (ФОРМАТ ISO)',
                ),array(
                    'name' => 'address_city',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: город',
                ),array(
                    'name' => 'address_metro',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: станция метро',
                ),array(
                    'name' => 'address_street',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: улица',
                    'help' => 'Если не указан, то по умолчанию из настроект;
                     Обязательное поле для указание Места проведения;',
                ),array(
                    'name' => 'address_building',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: дом',
                    'help' => 'Если не указан, то по умолчанию из настроект;
                     Обязательное поле для указание Места проведения;',
                ), array(
                    'name' => 'address_map',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: ссылка на карту',
                ),array(
                    'name' => 'address_phone',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: телефон, формат (ххх) ххх-хх-хх',
                ),array(
                    'name' => 'address_url',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Место проведения: ссылка на оф. сайт',
                ),array(
                    'name' => 'address_image',
                    'type' => 'knh9-0kgy-csg9-1nv8-7go9',
                    'editable' => '1',
                    'label' => 'Место проведения: фотография',
                ),array(
                    'name' => 'position',
                    'type' => 'opu03',
                    'editable' => '1',
                    'label' => 'Координаты',
                ),
            ),
        );
    }
	
	public static function indexTest() {
        return false;
    }

    public static function all() {
        return service("ar")
            ->collection(get_class());
    }     	
	
    /**
     * Возвращает мастеркласс
     **/
    public function masterclass() {
        return $this->pdata("mc");
    }
   
    public function asHTML() {
    
        if(!$this->exists()) {
            return "уточняется";
        }
    
        $html = "";
        $html .= "".$this->data("address_title") . "&nbsp;/ ";
        $html .= "<span style='white-space:nowrap;'>"."м.".$this->data("address_metro") . "</span>&nbsp;/ ";
        $html .= "<span style='white-space:nowrap;'>".$this->data("address_street") . "</span> ";
       
        if ($this->data("address_map") != null) {
            $html .= "<a href=\"".$this->data("address_map")."\" target=\"_blank\" >посмотреть на&nbsp;карте</a>";
        }
        
        return $html;
    }
    
    public function asText() {
    }

}