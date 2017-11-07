<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass  as Masterclass;
use Infuso\Site\Model\Event as Event;
use Infuso\Site\Model\Member as Member;
use Infuso\Core;

class Improve extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return [
            'name' => "improve",
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ],[
                    'name' => 'sort',
				    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
				    'editable' => '1',
                ],[
                    'name' => 'title',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'editable' => '1',
					'label' => 'Ценность',
                ],[
                    'name' => 'color',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'editable' => '1',
				    'label' => 'Цвет фона',
                ],
            ],
        ];
    }
    
    public function controller() {
        return "improve";
    }

    public static function indexTest() {
        return true;
    }

    public static function all() {
        return service("ar")
            ->collection(get_class())->asc("sort"); 
    }

    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }
	
	/**
     * Возвращает коллекцию мастерклассов по данной ценности
     **/
    public function masterclasses() {
        return Masterclass::all()->like("improve", '"'.$this->id().'"')->asc("Infuso\Site\Model\Event.date_start",true);
    }
    
    
    /**
     * Возвращает кол-во курсов по текущей ценности
     **/
    public function eventCountImprove() {
        return \Infuso\Site\Model\Event::all()
                    ->joinByField("pid")
                    ->visible()
                    ->primaryOnly()
                    ->match("Infuso\\Site\\Model\\Masterclass.improve", str_pad($this->id(), 5, "0", STR_PAD_LEFT))
                    ->count();
    }

    
    /**
     * Вывод шаблона коллекции 
     *
     * @return void
     **/
    public function index_item($p) {
        
        $improve = self::get($p['id']);
        
        $events = \Infuso\Site\Model\Event::all()
            ->applyQuery(array(
                "improve" => $improve->id(),
            ));
        
        app()->tm()->param("right-column", true);   
        
        app()->tm()->add("center", "/site/shared/events-head/improve",array(
            "improve" => $improve,
        )); 

		app()->tm()->add("center", "/site/events-list", array(
            "events" => $events,
        ));
        
        app()->tm("/site/layout")->exec();
    }
    
    /**
     * Возвращает подписчиков на эту ценность
     **/
    public function subscribers() {
    
        $id = str_pad($this->id(),5,0,STR_PAD_LEFT);
        return Member::all()
            ->eq("status", "news")
            ->joinByField("mc")
            ->match("Infuso\Site\Model\Masterclass.improve", $id);
    }
    
    /**
     * Возвращает кол-во курсов в improve с правильным склонением, без цифр 
     **/ 
   public function textCourse(){
       
        $count = $this->eventCountImprove();
        
        $a = $count % 10;
        $b = $count % 100;
    
        switch(true) {
            case($a == 0 || $a >= 5 || ($b >= 10 && $b <= 20)):
                $result = "курсов";
                break;
            case($a == 1):
                $result = "курс";
                break;
            case($a >= 2 && $a <= 4):
                $result = "курса";
                break;
        }

        return $result;
        
    }

}