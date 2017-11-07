<?

namespace Infuso\Site\Model;
use Infuso\Site\Model\CorporatePrograms  as CorporatePrograms ;
use Infuso\Site\Model\Category  as Category ;
use Infuso\Site\Model\Improve  as Improve;
use Infuso\Site\Model\Speaker  as Speaker;
use Infuso\Site\Model\McPlace  as McPlace;
use Infuso\Site\Model\Event  as Event;
use Infuso\Site\Model\Member as Member;
use Infuso\Site\Model\Review as Review;
use Infuso\Site\Model\McPhotoGallery as McPhotoGallery;
use Infuso\Core;

class Masterclass extends  \Infuso\ActiveRecord\Record{

    public static function model() {
        return array(
            'name' => "masterclass",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),array (
				    'name' => 'title',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'editable' => '1',
                    "wide" => true,
				    'label' => 'Название мастер-класса',
                ), array (
                    'name' => 'category',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'editable' => '1',
					'label' => 'Рубрика',
                    'class' => Category::inspector()->className(),
                ),array (
                    'name' => 'corporate_programs',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'editable' => '1',
					'label' => 'Раздел корпоративных программ',
                    'class' =>  CorporatePrograms::inspector()->className(),
                ),  array (
					'name' => 'speaker',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'editable' => '1',
					'label' => 'Преподаватель',
					'class' => Speaker::inspector()->className(),
                ), array (
					'name' => 'text',
				    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				    'editable' => '1',
				    'label' => 'Краткое описание для Списока мастер-класов',
                ), array (
					'name' => 'say',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'editable' => '1',
					'label' => 'Высказывание',
                ), array (
					'name' => 'text2',
					'type' => 'boya-itpg-z30q-fgid-wuzd',
					'editable' => '1',
					'label' => 'Подробное описание для детальной страницы',
                    "tinymce" => array(
                     "toolbar1"=>"newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
                    "toolbar2"=>"cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
                    "toolbar3"=>"table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft"
                    ),
                ), array (
					'name' => 'photo',
					'type' => 'knh9-0kgy-csg9-1nv8-7go9',
					'editable' => '1',
					'label' => 'Фото мастер-класса 365×273 px',
                ), array (
					'name' => 'rating',
				    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
				    'editable' => '1',
				    'label' => 'Рейтинг 0–5',
				), array (
					'name' => 'infopartners',
				    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
				    'label' => 'Информировать партнеров',
					'editable' => '1',
				), array (
					'name' => 'formcase',
				    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
				    'editable' => '1',
				    'label' => 'Форма отправки кейса',
				), array (
					'name' => 'improve',
					'type' => 'car3-mlid-mabj-mgi3-8aro',
					'editable' => '1',
					'label' => 'Ценности',
					'class' => Improve::inspector()->className(),
				), array (
					'editable' => 1,
					'name' => 'video',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'label' => 'Ссылка на видео',
					'help' => 'Пример видео: www.youtube.com/embed/78Yp-6iUhPM
					ИЛИ: player.vimeo.com/video/99508775',
				), array (
					'editable' => 1,
				    'name' => 'main_video',
				    'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
				    'label' => 'поставить видео вместо иллюстрации',
				), array (
					'name' => 'place',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Место проведения',
                    "editable" => 1,
					'class' => McPlace::inspector()->className(),
				),
            ),
        );
    }
	
	public function controller() {
        return "masterclass";
    }
	
	public static function indexTest() {
        return true;
    }
	
	 public static function postTest() {
        return true;
    }
	
	public static function all() {
        return service("ar")
            ->collection(get_class())
			->addBehaviour("infuso\\site\\behaviour\\masterclasscollection");
    }
    
    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }

	/**
	 * Возвращает родителя
	 **/
	public function recordParent() {
	    return $this->pdata("category");
	}
 
	 /**
     * Вывод шаблона коллекции 
     *
     * @return void
     **/
    public function index_item($p = null){
    
        $masterclass = self::get($p['id']);
        
        //Подготавливаем ближайшее будущие событие мастеркласса
        $event = \Infuso\Site\Model\Event::all()
                ->eq("pid", $masterclass->id())
                ->where("date_start > NOW() || open_date = 1")
                ->asc("open_date", true)
                ->asc("date_start", true);
        
        if ($_GET['event'] > 0) {
            $event->eq("id", $_GET['event']);  
        }
        
        $event = $event->one();
        
		app()->tm()->param("right-column", false);    
		app()->tm()->param("top-for-index", false); 
		app()->tm()->param("top-right-sidebar", true); 		

		app()->tm()->add("center", "/site/masterclass",array(
            "event" => $event,
            "masterclass" => $masterclass,
        ));
        app()->tm("/site/layout")->exec();
        
    }

	 /**
     * Возвращает список всех событий мастеркласса
     */ 
    public function events() {
        return Event::all()
            ->eq("pid", $this->id());
    }
	
	public function reviews() {         
        return Review::all()
            ->asc("verified")
            ->eq("masterclass", $this->id());
    }
	
	public function speaker() {
        return $this->pdata("speaker");
    }
	
	public function members_news() {
        return Member::all()
            ->eq("mc", $this->id());
    }
	
	public function post_case($post = null) {
        
        $mc = self::get($post['mc']);
        
        $text = "Кейс от пользователя <br />\r\n";
        $text .= "Имя: {$post['name']} <br />\r\n";
        $text .= "Фамилия: {$post['surname']} <br />\r\n";
        $text .= "Телефон: {$post['phone']} <br />\r\n";
        $text .= "E-mail: {$post['email']} <br />\r\n";
        $text .= "--- <br />\r\n";
        $text .= "Мастер-класс: ". $mc->title() . " http://cityclass.ru" . $mc->url() . " <br />\r\n";
        
        $files = array($_FILES['file']['name'] => file_get_contents($_FILES['file']['tmp_name']));
        
      /*  site_mail::mail_to(mod::conf("mod:admin_email"), "\"Сити Класс\" <".mod::conf("mod:admin_email").">", "Кейс от пользователя", $text, $files);*/
        
    }
	
	public function place() {
        return $this->pdata("place");
    }
    
    public function sailplayrate() {
        return $this->data("sailplayrate");
    }
	
	public function beforeStore() {
        if( $this->data("sailplayrate") > 100){
           app()->msg("Коэффициент Sailplay не может быть больше 100%",1);
           return false;
        }
    }
	
	/**
     * Возвращает коллекцию изображений для элемента
     **/         
    public function gallery() {
        return McPhotoGallery::all()
            ->eq("mcID", $this->id())->limit(0);
    }
	
}