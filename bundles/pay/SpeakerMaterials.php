<?php

namespace Infuso\Site\Model;
use Infuso\Site\Model\Speaker  as Speaker;
use Infuso\Core;

/**
* Полезные материалы спикера
**/

class SpeakerMaterials extends  \Infuso\ActiveRecord\Record
{
	
    public static function model()
    {
        return array(
            'name' => 'speaker_materials',
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
                    'name' => 'tag',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'label' => 'Tag',
                    "editable" => true,
                ),array (
                    'name' => 'content',
				    'type' => 'boya-itpg-z30q-fgid-wuzd',
					'editable' => '1',
                    "tinymce" => array(
                        "toolbar" => "undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect | forecolor backcolor | removeformat pastetext | link ", 
                    ),
				    'label' => 'Контент страницы',
                ),array (
					'name' => 'speaker',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'editable' => '1',
					'label' => 'Преподаватель',
					'class' => Speaker::inspector()->className(),
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
	
	 public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }
    
    public function speaker() {
        return $this->pdata("speaker");
    }
	
	public function index_item($p = null){
        
        $item = self::get($p['id']);
		app()->tm()->add("center", "/site/speakers/materials/item",array("item"=>$item));
        app()->tm("/site/layout")->exec();
    }
    
    public function index(){
    
		app()->tm()->param("right-column", true);    		
		app()->tm()->add("center", "/site/speakers/materials/all");
        app()->tm("/site/layout")->exec();
    }
}