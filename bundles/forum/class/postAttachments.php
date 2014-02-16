<?php
/**
 * Модель
 *
 * @package site
 * @author Petr.Grishin
 **/
class forum_postAttachments extends reflex {
    
    

public static function recordTable() {return array (
  'name' => 'forum_postAttachments',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => 'ggu3hjgkulv572bhbwtx3tme71zvdc',
    ),
    1 => 
    array (
      'name' => 'postId',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'id' => 'rdl4zpd0d1ev8pu1ffljrh5vu1tk7c',
      'label' => 'Сообщение',
      'indexEnabled' => 0,
      'class' => 'forum_post',
    ),
    2 => 
    array (
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => 'onvk6gygiwl4c8s39atsud6ljzb88m',
      'label' => 'Наименование',
      'indexEnabled' => 0,
    ),
    3 => 
    array (
      'name' => 'file',
      'type' => 'knh9-0kgy-csg9-1nv8-7go9',
      'editable' => '1',
      'id' => 'au7jpjdb41ooas5oha4tswx5235cr6',
      'label' => 'Файл',
      'indexEnabled' => 0,
    ),
  ),
  'indexes' => 
  array (
  ),
);}

/**
     * Возвращает текущею коллекцию
     *
     * @return reflex_list
     **/
    public static function all() { 
        return reflex::get(get_class())
            ->limit(0);
    }
    
    
    /**
     * Возвращает атач по id
     *
     * @return forum_postAttachments
     **/
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }
    
    /**
     * Возвращает true если файл являеться фотографией
     *
     * @return boolean
     **/
    public function typeImg() {
        $typeImg = array("jpg", "jpeg", "png", "gif");
        $ext = $this->pdata("file")->ext();
        return in_array($ext, $typeImg);
    }
    
    public function post() {
        return $this->pdata("postId");
    }
    
    public function reflex_parent() {
        return $this->post();
    }
    
    public function reflex_storageSource() {
        return $this->post();
    }
    
    
} //END CLASS
