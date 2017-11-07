<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Event as Event;
use Infuso\Site\Model\Member as Member;
use Infuso\Core;

class Category extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return [
            'name' => "category",
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ],[
                  	'name' => 'priority_speaker',
					'type' => 'bigint',
					'label' => 'приоритет для страницы спикеров',
					"editable" => false,
                ],[ 
                    'name' => 'title',
                    'type' => 'textfield',
                    'label' => 'Название',
                     "editable" => true,
                ],[
                    'name' => 'icons',
                    'type' => 'file',
                    'label' => 'Иконка в меню',
                    "editable" => true,
                ],[
                    'name' => 'color',
                    'type' => 'textfield',
                    'label' => 'Цвет раздела (хэш запись с #)',
                    "editable" => true,
                ],
            ],
        ];
    }
    
    public function controller() {
        return "category";
    }

    public static function indexTest() {
        return true;
    }

    public static function all() {
        return service("ar")
            ->collection(get_class());
    }

    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }
    
    /**
     * Вывод шаблона коллекции
     *
     * @return void
     **/
    public function index_item($p) {
        
        $category = self::get($p["id"]);

		app()->tm()->param("right-column", true);  
		
        $events = Event::all()
            ->applyQuery(array(
                "category" => $category->id(),
            ));
        
        app()->tm()->add("center", "/site/shared/events-head/category",array(
            "category" => $category,
        )); 
        
		app()->tm()->add("center", "/site/events-list",array(
            "events" => $events,
        ));            
		app()->tm("/site/layout")->exec();
    }
    
    /**
     * Возвращает спикеров данной категории
     **/
    public function getSpeakers() {
         $actualSpeakers = \Infuso\Site\Model\Speaker::all()
            ->join(\Infuso\Site\Model\Masterclass::all(), "`Infuso\\Site\\Model\\Masterclass`.`speaker` = `Infuso\\Site\\Model\\Speaker`.`id`")
            ->join(\Infuso\Site\Model\Event::all(), "`Infuso\\Site\\Model\\Event`.`pid` = `Infuso\\Site\\Model\\Masterclass`.`id`")
            ->eq("Infuso\\Site\\Model\\Event.primary", true)
            ->eq("Infuso\\Site\\Model\\Masterclass.category", $this->id())
            ->eq("Infuso\Site\Model\Event.open_date", false)
            ->groupBy("Infuso\\Site\\Model\\Speaker.id")
            ->gt("Infuso\Site\Model\Event.date_start", \Infuso\Util\Util::now())
            ->orderByExpr("MIN(`Infuso\Site\Model\Event`.`date_start`) asc");
            
           return $actualSpeakers;
    }
    
    
  
    
    /**
     * Возвращает кол-во курсов по текущей категории
     **/
    public function eventCountCategory() {
        return \Infuso\Site\Model\Event::all()
                    ->joinByField("pid")
                    ->visible()
                    ->primaryOnly()
                    ->eq("Infuso\\Site\\Model\\Masterclass.category", $this->id())
                    ->count();
    }
	
	/**
     * Возвращает подписчиков на эту ценность
     **/
    public function subscribers() {
        return Member::all()
            ->eq("status", "news")
            ->joinByField("mc")
            ->eq("Infuso\Site\Model\Masterclass.category", $this->id());
    }
 
    /**
     * Возвращает кол-во курсов в категории с правильным склонением, без цифр 
     **/ 
   public function textCourse(){
       
        $count = $this->eventCountCategory();
        
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