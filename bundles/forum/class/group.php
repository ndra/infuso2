<?php
/**
 * Модель и контроллер
 *
 * @package site
 * @author Petr.Grishin
 **/
class forum_group extends reflex {

    

public static function reflex_table() {return array (
  'name' => 'forum_group',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => 'khbbutiii6421ncpr9fiim5myicxmj',
    ),
    1 => 
    array (
      'name' => 'sort',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'id' => 'ee2vq3vv7dy1ii1qwqhrfl1b7w0y6w',
      'indexEnabled' => '0',
    ),
    2 => 
    array (
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => '8tbh7gkv9qmgye51lw4b77d6a74872',
      'label' => 'Название группы',
      'indexEnabled' => '0',
    ),
    3 => 
    array (
      'name' => 'parent',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'id' => 'zk5khmjf79dqqgo2ejbwb6299yudcv',
      'label' => 'Родительская группа',
      'indexEnabled' => '0',
      'class' => 'forum_group',
    ),
    4 => 
    array (
      'name' => 'desc',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '1',
      'id' => 'grhzo4148bbvkf2yofcykczm1vzxtc',
      'label' => 'Описание',
      'indexEnabled' => '0',
    ),
  ),
  'indexes' => 
  array (
  ),
  'fieldGroups' => 
  array (
    0 => 
    array (
      'name' => NULL,
      'title' => NULL,
    ),
  ),
);}

/**
     * Видимость класса для http запросов
     *
     * @return boolean
     **/
    public static function indexTest() {
        return true;
    }

    /**
     * Видимость класса для POST запросов
     *
     * @return boolean
     **/
    public function postTest() {
        return true;
    }

    /**
     * Вывод колекции
     *
     * @return array
     **/
    public function index() {
        tmp::exec("/forum/index");
    }


    /**
     * Вывод эелемента колекции
     *
     * @return array
     **/
    public function index_item($p) {

        $group = self::get($p["id"]);
        tmp::exec("/forum/group",array(
            "group" => $group,
        ));
    }

    /**
     * Метаданные в админке
     *
     * @return boolean
     **/
    public function reflex_meta() {
        return true;
    }


    /**
     * Возвращает текущею коллекцию
     *
     * @return reflex_list
     **/
    public static function all() {
        return reflex::get(get_class())
            ->asc("sort")
            ->param("sort",true);
    }

    /**
     * Возвращает группу по id
     *
     * @return forum_group
     **/
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }

    /**
     * Возвращает корневые элементы коллекции
     *
     * @return reflex_list
     **/
    public static function root() {
        return self::all()->eq('parent', 0);
    }


    /**
     * Возвращает кол-во сообщений в форуме
     *
     * @return reflex_list
     **/
    public function countPosts() {

        $count = 0;

        foreach ($this->children_topic() as $topic) {
            $count += $topic->countPosts();
        }

        return $count;
    }



    /**
     * Вывод родительской группы
     *
     * @return array
     **/
    public function reflex_parent() {
        return self::get($this->data("parent"));
    }


    /**
     * Вывод дочерних групп
     *
     * @return reflex_list
     **/
    public function childrenGroups() {
        return self::all()
            ->eq("parent", $this->id())
            ->asc("sort")
            ->param("sort",true);
    }


    /**
     * Вывод Тем
     *
     * @return reflex_list
     **/
    public function _topics() {
        return forum_topic::all()
            ->eq("group", $this->id())
            ->asc("date");
    }

    public function lastPost() {
        $topics = $this->topics()->idList();
        $post = forum_post::all()->eq("topic",$topics)->desc("date")->one();
        return $post;
    }


    /**
     * Дочерние группы
     *
     * @return array
     **/
    public function reflex_children() {
        return array(
            $this->childrenGroups()->title("Дочерние группы"),
            $this->topics()->title("Темы")
        );
    }

    /**
     * Настройка админки Название Группы влевом меню
     *
     * @return array
     **/
    public function reflex_rootGroup() {
        return "Форум";
    }


    /**
     * Подписаться на тему
     *
     * @return array
     **/
    public function post_subscribe($p = null) {

        if (!user::active()->exists())
            throw new Exception("Вы не авторизовались");


        $group = reflex::get("forum_group", $p["id"]);

        //Подписываю на Group
        user::active()->subscribe("forum:group:".$group->id(), "Новое сообщение на форуме: " . $group->title());

        mod::msg("Вы подписаны на форум: " . $group->title());
    }


} //END CLASS
