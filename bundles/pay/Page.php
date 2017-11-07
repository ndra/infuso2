<?php

namespace Infuso\Site\Model;
use Infuso\Core;

class Page extends  \Infuso\ActiveRecord\Record
{
	
    public static function model()
    {
        return array(
            'name' => 'page',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
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