<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Improve as Improve;
use Infuso\Site\Model\Category as Category;
use Infuso\Site\Model\Masterclass as Masterclass;
use Infuso\Site\Model\Member as Member;
use Infuso\Site\Model\OpenDateMember as OpenDateMember;
use Infuso\Core\Url as Url;
use Infuso\Core;

class Event extends  \Infuso\ActiveRecord\Record implements \Infuso\Cms\Search\Searchable{

    public static function model() {
        return array(
            'name' => "event",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
					'name' => 'pid',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Мастер-класс',
					'class' => Masterclass::inspector()->className(),
					//"editable" => 1,
				), array (
                    'name' => 'creationDate',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => 0,
                    'label' => 'Дата создания события',
                    "default" => "now()",
                ), array (
					"name" => "closed",
					"type" => "checkbox",
					"label" => "Закрыть регистрацию",
					"editable" => true,
				), array (
					"name" => "open_date",
					"type" => "checkbox",
					"label" => "Открытая дата",
					"editable" => true,
				), array (
					'name' => 'date_start',
					'type' => 'datetime',
					'label' => 'Дата и время начала ',
					"editable" => true,
				), array (
                  'name' => 'time',
                  'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                  'editable' => '1',
                  'label' => 'Продолжительность в часах',
                ), array (
                  'name' => 'minute',
                  'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                  'editable' => '1',
                  'label' => 'Продолжительность в минутах',
                ), array (
                  'name' => 'price',
                  'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                  'editable' => '1',
                  'label' => 'Стоимость в рублях',
                ), array (
                  'name' => 'pricevip',
                  'type' => 'nmu2-78a6-tcl6-owus-t4vb',
                  'editable' => '1',
                  'label' => 'vip стоимость',
                ), array (
                  'name' => 'primary',
                  'type' => 'checkbox',
                  'editable' => 3,
                  'label' => 'Первое в списке',
                ), 
            ),
        );
    }
	
	public static function postTest() {
        return true;
    }
    
    public static function all() {
        return service("ar")
            ->collection(get_class())
			->addBehaviour("infuso\\site\\behaviour\\eventCollection")
            ->asc("open_date")
            ->asc("date_start", true);
    }
	
    /**
     * Возвращает мастеркласс
     **/
	public function masterclass() {
        return $this->pdata("pid");
    }
    
    /**
     * Возвращает коллекцию типов билетов события
     **/
    public function ticketTypes() {
        return TicketType::all()->eq("eventId", $this->id());
    }
	
	 /**
     * Возвращает список участников мероприятия
     * которые подтвердили заявки (дошли до конца в форме отправки)
     **/
    /*public function members() {
        return Member::all()
            ->joinByField("pid")
            ->eq("site_registration.event", $this->id())
            ->eq("site_registration.finished", true);
    }*/
	
	/**
	 * Возвращает родителя
	 **/
	public function recordParent() {
	    return $this->masterclass();
	}

	 /**
     * Возвращает признак открытой даты
     **/
    public function openDate() {
        return $this->pdata("open_date");
    }
	
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
	
	
	 /**
     * Заполняем данные по умолчанию только что созданого элемента
     **/
    /*public function beforeCreate() {
        //Валидация обязательных полей
        if ((integer)$this->data("plannedRegistrations") < 1) {
            app()->msg("Укажите плановое число регистраций", true);
            return false;
        }
    }  */
    
    
    /**
     * Возвращает список записавшихся пользователей, когда у события была открытая дата
     **/
    public function openDateMembers() {         
        return OpenDateMember::all()->eq("event", $this->id());
    }
	
	public function afterStore() {
        
        //Если событие закрывают, то создаем событие Открытая дата
        if ($this->data("closed")) {
            
            //Если нет будущих незакрытых дат
            $next = self::all()
                ->neq("id", $this->id())
                ->eq("pid", $this->data("pid"))
                ->eq("closed", false)
                ->where("date_start > NOW() || open_date = 1");
                
            if ($next->count() == 0 && $this->data("open_date") != 1) {
              
				service("ar")->create(self::inspector()->className(),array(
					"pid" => $this->data("pid"),
                    "time" => $this->data("time"),
                    "minute" => $this->data("minute"),
                    "price" => $this->data("price"),
                    "pricevip" => $this->data("pricevip"),
                    "plannedRegistrations" => $this->data("plannedRegistrations"),
                    "open_date" => true,
				)); 
                
                app()->msg("Создаем открытое событие");
            }
        }
    }
	
	/*public function afterCreate() {
    
        if ($this->masterclass()->data("infopartners") == 1){

			service("task")->add(array(
				"class" => "\Infuso\Site\Model\InfoPartners",
				"method" => "mailPartner",
				"params" => array(
					"eventId" => $this->id(),
				)
			));		
        }
    }*/
  
    public function isPrimary() {
    
        // Убираем свойство 'primary', если МК удален  
        if(!$this->masterclass()->exists()) {
            return false;
        }
    
        $events = $this->masterclass()->events()
            ->visible()
            ->asc("open_date")
            ->asc("date_start", true)
            ->asc("id", true);
            
        return $events->one()->id() == $this->id();
        
    }
    
    public function updatePrimary() {
        $this->data("primary", $this->isPrimary());
    }
    
    public function recordUrl() {
        return $this->masterclass()->url();
    }
    
    public function searchContent() {
        
        //добавляем событие только если оно главное
        if($this->isPrimary()){
            
            //для всех событий с датами приоритет 0
            $priority = 0;
            
            //для сортировки asc назначаем для открытых дат приоритет 1
            if($this->openDate()){
                $priority = 1;    
            }
            
            return array(
                "content" => $this->pdata("pid")->title()." ".$this->pdata("pid")->pdata("speaker")->title(),
                "priority" => $priority,
                "snippet" => "/site/search/event-snippet",
            );       
        }
        
        return false;
        
    }
    
}