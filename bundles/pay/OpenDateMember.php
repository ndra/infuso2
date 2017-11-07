<?php

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Модель хранилища заявок на открытые даты 
 **/
class OpenDateMember extends  \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
					'name' => 'event',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Событие',
					'editable' => 1,
					'class' => Event::inspector()->className(),
				), array (
					'name' => 'creationDate',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					'editable' => 2,
					'label' => 'Дата создания заявки',
					"default" => "now()",
                ),array (
					'name' => 'email',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'email',
                ),array (
					'name' => 'name',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Имя',
                ),array (
					'name' => 'surname',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Фамилия',
                ),array (
					'name' => 'phone',
					'type' => 'textfield',
					'editable' => '1',
					'label' => 'Телефон',
                ),
            ),
        );
    }
	
    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->desc("creationDate");
    }
	
	public function event() {
        return $this->pdata("event");
    }
	
	/**
	 * Возвращает родителя
	 **/
	public function recordParent() {
	    return $this->event();
	}
	
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
	

    
}