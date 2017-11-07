<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class PageMenu extends  \Infuso\ActiveRecord\Record
{
	
    public static function model()
    {
        return array(
            'name' => 'pagemenu',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),array (
                  'name' => 'priority',
                  'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
                  'editable' => '0',
                  'label' => 'Приоритет',
                ), array (
                  'name' => 'parent',
                  'type' => 'pg03-cv07-y16t-kli7-fe6x',
                  'editable' => '0',
                  'label' => 'Родительский каталог',
				  'class' => PageMenu::inspector()->className(),
                ),array (
                    'name' => 'title',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'label' => 'Заголовок',
                    "editable" => true,
                ),array (
                    'name' => 'content',
				    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				    'editable' => '1',
				    'label' => 'Контент страницы',
                ), array (
                  'name' => 'url',
                  'type' => 'v324-89xr-24nk-0z30-r243',
                  'editable' => '1',
                  'label' => 'URL',
                ),
            ),
        );
    }
	
	public static function indexTest() {
        return true;
    }
	
	 public static function postTest() {
        return false;
    }

    public static function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    public function recordUrl() {
		if($this->data("url")!=""){
            return $this->data("url");
        }
	}
	
	/**
	 * Возвращает родителя - родительскую страницу
	 **/
	public function recordParent() {
	    return self::get($this->data("parent"));
	}
	
	public function childrenPages() {
        return self::all()->eq("parent", $this->id());
    }
	
	public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
	
	public function index_item($p = null){
        
        $item = self::get($p['id']);
		
		app()->tm()->param("right-column", true);    		
		app()->tm()->add("center", "/site/page/template",$item);
        app()->tm("/site/layout")->exec();
    }
}