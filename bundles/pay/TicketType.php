<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class TicketType extends  \Infuso\ActiveRecord\Record {

    public static function model() {
        return array (
            "name" => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'eventId',
                    'type' => 'link',
                    "class" => "Infuso\\Site\\Model\\Event"
                ), array (
                    'name' => 'name',
                    'label' => "Наименование",
                    'type' => 'string',
                    "editable" => true,
                ), array (
                    'name' => 'price',
                    'type' => 'price',
                    'label' => "Цена",
                    "editable" => true,
                ), array (
                    'name' => 'timepadId',
                    'type' => 'integer',
                    'label' => "ID таймпэда",
                    "editable" => 2,
                ), 
            ),
        );
    }
    
    public static function all() {
        return service("ar")->collection(get_class());
    }
    
    public function recordParent() {
        return $this->pdata("eventId");
    }
    
    public function beforeStore() {
        $triggerFields = array (
            "price",
            "name",
        );
        foreach($triggerFields as $name) {
            if($this->field($name)->changed()) {
                $this->parent()->data("timepadStatus", \Infuso\Site\Behaviour\TimepadEvent::STATUS_WAIT_FOR_SYNC);
                break;
            }
        }
    }
    
    public function beforeCreate() {   
        $this->parent()->data("timepadStatus", \Infuso\Site\Behaviour\TimepadEvent::STATUS_WAIT_FOR_SYNC);
    }
    
    public function beforeDelete() {
        $this->parent()->data("timepadStatus", \Infuso\Site\Behaviour\TimepadEvent::STATUS_WAIT_FOR_SYNC);
    }
	
    
}