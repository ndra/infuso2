<?

namespace Infuso\Site\Model;
use Infuso\Core;

class VideoCourse extends  \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
            'name' => "vodeo_course",
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
				    'name' => 'title',
				    'type' => 'v324-89xr-24nk-0z30-r243',
				    'editable' => '1',
                    "wide" => true,
				    'label' => 'Название мастер-класса',
                ), array (
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
                ), 
            ),
        );
    }
	
	public function controller() {
        return "videocourse";
    }
	
	public static function indexTest() {
        return true;
    }

	
	public static function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }
    
    public function index($p) {
        app()->tm("/site/videocourses")
            ->param("courses", self::all())
            ->exec();
    }
    
    public function speaker() {
        return $this->pdata("speaker");
    }
 
	 /**
     * Вывод шаблона коллекции 
     *
     * @return void
     **/
    public function index_item($p = null) {
    
      /*  $masterclass = self::get($p['id']);
        
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
        app()->tm("/site/layout")->exec();   */
        
    }	
}