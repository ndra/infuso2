<?php

namespace Infuso\Site\Controller;
use Infuso\Core;
use Infuso\Util\Date as utilDate;
use Infuso\Site\Form\SpeakerQuestion as SpeakerQuestionForm;
use Infuso\Site\Model\Question as QuestionModel;
use Infuso\Site\Form\Review as ReviewForm;
use Infuso\Site\Model\Review as Review;
use Infuso\Site\Model\Member  as Member;
use Infuso\Site\Form\Invite as InviteForm;
use Infuso\Site\Form\Subscribe as SubscribeForm;
use Infuso\Site\Model\Invite as Invite;
use Infuso\Site\Model\OpenDateMember as OpenDateMember;


class Forms extends Core\Controller{

    public function postTest() {
        return true;
    }

    public function post_addSpeakerQuestion($p) {
        
        if(!$p || $p["g-recaptcha-response"] == ""){
            throw new \Exception("Нет данных");
        }
		
		app()->msg("<h1>Спасибо!</h1><div> Ваш вопрос отправлен</div>");
		
		service("ar")->create(QuestionModel::inspector()->className(),array(
			"speaker"=>$p["speaker"],
			"question"=>$p["question"],
			"from"=>$p["from"],
			"email"=>$p["email"],
		));
    }
    
    
     /**
     * Регистрация на семинар с открытой датой
     */
    public function post_openDateRegistration($post) {
        
        $event = \Infuso\Site\Model\Event::get($post['event']);
        
        if($event->exists()){
            // Отправляем письмо админу
            
            $message = "";
            $message.= "Мастеркласс: ".$event->masterclass()->title()."\n";
            $message.= "Дата проведения - открытая дата "."\n";
            $message.= "Стоимость: ".$event->data("price")." р.\n";
                
            for ($i=0; $i < count($post["name"]); $i++) {
                
                $message.= "Имя: ".$post["name"][$i]."\n";
                $message.= "Фамилия: ".$post["surname"][$i]."\n";
                $message.= "Телефон: ".$post["phone1"][$i].$post["phone2"][$i].$post["phone3"][$i]."\n";
                $message.= "Почта: ".$post["email"][$i]."\n";
                $message.= "\n\n";
                
                
                //заявки
                service("ar")->create(OpenDateMember::inspector()->className(),array(
        			"event"=>$event->id(),
        			"name"=>$post["name"][$i],
        			"surname"=>$post["surname"][$i],
        			"phone" => $post["phone1"][$i].$post["phone2"][$i].$post["phone3"][$i],
        			"email" => $post["email"][$i],
        			"creationDate" => \Infuso\Util\Util::now(),
        		));
        		
        		$member = Member::getByEmail($post["email"][$i]);
        		
        		if($member->exists()){
        		    if($member->data("type") == Member::TYPE_UNSUBSCRIBE){
        		        $member->data("type", Member::TYPE_OPENDATE);  
        		        $member->data("exported", false); 
        		    }
        		} else {
        		    //заявители
            		$member = service("ar")->create(Member::inspector()->className(),array(
            			"mc"=>$event->masterclass()->id(),
            			"email" => $post["email"][$i],
            			"name"=>$post["name"][$i],
            			"phone" => $post["phone1"][$i].$post["phone2"][$i].$post["phone3"][$i],
            			"type" => Member::TYPE_OPENDATE,
            		));      
        		}
        		
        		app()->fire("member/add-sailplay", array(
        		    "deliverToClient" => true,
                    "member" => $member,
                ));
                
            }
            
            $adminMail = service("reflexconf")->get("register:openDate:adminmail");    
            
            service("mail")->create()
                ->to($adminMail)
                ->subject("Регистрация на мастер-класс")
                ->from("no-reply@cityclass.ru")
                ->message($message)
                ->send();    
                
            app()->msg("<h1 style='padding:10px'>Ваша заявка отправлена!</h1>");
        }
        
        return false;

    }
    
    
    /**
     * Добавляем подписчика, который соизволил оставить свои данные
     */
    public function post_addMailingMember($post) {
        
        if($post["data"] != ""){
            $post = $post["data"];
        }
        
        $form = new SubscribeForm();
		if(!$form->validate($post)){
            return false;
        }

        $member = Member::getByEmail($post["email"]);
        		
		if($member->exists()){
		    if($member->data("type") == Member::TYPE_UNSUBSCRIBE){
		        $member->data("type", Member::TYPE_SUB_FORM);  
		        $member->data("exported", false); 
		    }

		} else {
		   	$member = service("ar")->create(Member::inspector()->className(),array(
    			"email" => $post["email"],
    			"name"=>$post["name"],
    			"type" => Member::TYPE_SUB_FORM,
    		));   
		}
		
		app()->cookie("NoShowSubscribe", true);
	
		app()->fire("member/add-sailplay", array(
		    "deliverToClient" => true,
            "member" => $member,
        ));
        
        return true;

    }
    
    
    /**
     * Удаляем подписчика, который решил отказатся от подписки
     */
    public function post_removeMailingMember($post) {
        
        if(!$post || $post["email"] == ""){
            return false;
        }
        
        $member = Member::getByEmail($post["email"]);
        		
		if($member->exists()){
		    
		    if($member->data("type") != Member::TYPE_UNSUBSCRIBE){
		        $member->data("type", Member::TYPE_UNSUBSCRIBE);  
		        $member->data("exported", false); 
		    }
		    
		    app()->fire("member/remove-sailplay", array(
    		    "deliverToClient" => true,
                "member" => $member,
            ));
		}
        return true;

    }
	
	
	 /**
     * Сохраняем форму Вопрос
     */
    public function post_review($post) {
        
		if(!$post || $post["g-recaptcha-response"] == ""){
            throw new \Exception("Нет данных");
        }
		
		$item = service("ar")->create(Review::inspector()->className(),array(
			"masterclass"=>$post["masterclass"],
			"name"=>$post["name"],
			"surname"=>$post["surname"],
			"review" => $post["review"],
			"email" => $post["email"],
			"date" => \util::now(),
		));
    }
	
	public function post_newsemail($post) {
        if ($post && $post["email"] != ''):
            //Создаем участника
			$member = service("ar")->create(Member::inspector()->className(), array(
                "sp" => $post["sp"],
                "email" => $post["email"],
            ));
            $member->store();
            app()->msg("<h1 style='padding:10px'>Вы успешно подписались!</h1>");
         endif;
    }
	
	/**
     * сохраняем форму приглашения и отсылаем
     */
    public function post_addinvite($p) {
    
		$form = new InviteForm();
		if(!$form->validate($p)){
            throw new \Exception("Ошибка валидации формы");
        }
		$form->fill($p);
		
		$item = service("ar")->create(Invite::inspector()->className(),array(
			"masterclass"=>$p["masterclass"],
			"fromname"=>$p["fromname"],
			"fromemail"=>$p["fromemail"],
			"name" => $p["name"],
			"email" => $p["email"],
		));
		
		$masterclass = \Infuso\Site\Model\Masterclass::get($p["masterclass"]);
		$user = array("fromname"=>$p["fromname"],"name" => $p["name"]);
		$text = app()->tm("/site/invite/email")->param("masterclass", $masterclass)->param("user", $user)->rexec();
		$subject = '' . $item->data("fromname") . ' пригласил(а) Вас на мастер-класс';
            
        $mailer = service("mail")->create();
		$mailer->from($item->data("fromname").' <'.$item->data("fromemail").'>');
		$mailer->to($item->data("name").' <'.$item->data("email").'>');
		$mailer->subject($subject);
		$mailer->type("text/html");
		$mailer->code("mailing/invite");
		$mailer->param("text",$text);
		$mailer->send();
		
		app()->msg("<h1 style='padding:10px'>Письмо отправлено!</h1>");
    }
} 