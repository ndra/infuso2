<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass  as Masterclass;
use Infuso\Site\Model\Event as Event;
use Infuso\Site\Model\Speaker  as Speaker;
use Infuso\Core;

class Member extends \Infuso\ActiveRecord\Record {
    
     /**
     * Типы пользователей
     **/
    const TYPE_ALL  = 0; //обычная регистрация
    const TYPE_OPENDATE = 1; //по открытой дате
    const TYPE_SUB_FORM = 2; //через форму добровольной подписки
    const TYPE_UNSUBSCRIBE = 3; //отказался от подписки
	
    public static function model() {
        return array (
              'name' => 'member',
              'fields' => array(
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
                ), array(
                    'name' => 'sp',
                    'type' => 'pg03-cv07-y16t-kli7-fe6x',
                    'editable' => '2',
                    'label' => 'Докладчик',
                    'class' => Speaker::inspector()->className(),
                    'indexEnabled' => 1,
                ), array(
                    'name' => 'name',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Имя',
                ), array(
                    'name' => 'email',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'E-mail',
                ), array(
                    'name' => 'phone',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => 'Телефон',
                ),array (
					'name' => 'type',
					'type' => 'fahq-we67-klh3-456t-plbo',
					'editable' => 1,
					'label' => 'Тип регистрации',
					'method' => 'enumTypes',
                ), array(
                    'name' => 'exported',
                    'type' => 'checkbox',
                    'label' => 'Экспортирован',
                    'editable' => 1,
                ),
              ),
        );
    }

    public static function all() {
        return service("ar")
            ->collection(get_class());
    }

    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public static function getByEmail($email) {
        return self::all()->limit(0)->eq("email", $email)->one();
    }
    
    public function enumTypes() {
        return array(
            self::TYPE_ALL  => "Обычная регистрация",
            self::TYPE_OPENDATE => "Открытая дата",
            self::TYPE_SUB_FORM => "Форма добровольной подписки",
            self::TYPE_UNSUBSCRIBE => "Отказался от подписки",
        );
    }
	
	 /**
     * Возвращает объект мастеркласса для этого участника
     **/
    public function masterclass() {
        return $this->pdata("mc");
    }
    
    public function speaker() {
        return $this->pdata("sp");
    }

}