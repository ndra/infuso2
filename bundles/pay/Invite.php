<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass as Masterclass;
use Infuso\Site\Form\Invite as InviteForm;
use Infuso\Core;

class Invite extends  \Infuso\ActiveRecord\Record
{

    public static function model()
    {
        return array(
            'name' => 'invite',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),array (
                    'name' => 'creationDate',
                    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
                    'editable' => 0,
                    'label' => 'Дата создания',
                    "default" => "now()",
                ),array (
                    'name' => 'masterclass',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Мастер-класс',
					'class' => Masterclass::inspector()->className(),
					"editable" => true,
                ),array (
                    'name' => 'fromname',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'label' => 'Имя отправителя',
					"editable" => true,
                ),array (
                    'name' => 'fromemail',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'label' => 'Почта отправителя',
					"editable" => true,
                ),array (
                    'name' => 'name',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'label' => 'Имя получателя',
					"editable" => true,
                ),array (
                    'name' => 'email',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'label' => 'Почта получателя',
					"editable" => true,
                ),array (
                   'name' => 'sent',
				   'type' => 'checkbox',
				   'editable' => true,
				   'label' => 'Отправлено приглашение',
                ),
            ),
        );
    }
	
	public static function indexTest() {
        return true;
    }
	
	public static function postTest() {
        return true;
    }
	
	public static function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
	
}