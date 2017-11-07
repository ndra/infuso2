<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Masterclass as Masterclass;
use Infuso\Core;

class Review extends  \Infuso\ActiveRecord\Record
{

    public static function model()
    {
        return array(
            'name' => 'review',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),array (
                    'name' => 'masterclass',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Мастер-класс',
					'class' => Masterclass::inspector()->className(),
					"editable" => true,
                ),array (
                    'name' => 'name',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'label' => 'Имя',
					"editable" => true,
                ),array (
                    'name' => 'surname',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'label' => 'Фамилия',
					"editable" => true,
                ),array (
                    'name' => 'review',
				    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				    'label' => 'Отзыв',
					"editable" => true,
                ),array (
                    'name' => 'email',
					'type' => 'v324-89xr-24nk-0z30-r243',
					'label' => 'Email',
					"editable" => true,
                ),array (
                    'name' => 'date',
				    'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
				    'editable' => '1',
				    'label' => 'Дата',
                    "default" => "now()",
                ),array (
                   'name' => 'verified',
				   'type' => 'checkbox',
				   'editable' => true,
				   'label' => 'Проверен',
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
	
	public static function index($p = null) {
        
        $m = $p['m'] == null ? 0 : $p['m'];
        $page = $p['page'] == null ? 1 : $p['page'];
        
        if ($m == 0) {
			$review =  self::all()->eq("verified", 1)->desc("date")->page($page)->limit(10);
        } else {
            $review = self::all()->eq("verified", 1)->eq("masterclass", $m)->desc("date")->page($page)->limit(10);
        }
        $review->param("pageurl", "?page=%page%");
		app()->tm()->param("right-column", true);    		

		app()->tm()->add("center", "/site/reviews/list",array(
             "reviews" => $review,
			 "m" => $m,
        ));
		app()->tm()->add("center", "/site/shared/pager",array(
             "items" => $review,
        ));
        app()->tm("/site/layout")->exec();
       
    }

	/**
	 * Возвращает родителя
	 **/
	public function recordParent() {
	    return service("ar")->get(Masterclass::inspector()->className(),  $this->data("masterclass")); 
	}
}