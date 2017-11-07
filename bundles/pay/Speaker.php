<?

namespace Infuso\Site\Model;
use Infuso\Site\Model\Member  as Member;
use Infuso\Site\Model\SpeakerMaterials  as SpeakerMaterials;
use Infuso\Site\Model\Question  as Question;
use Infuso\Core;

class Speaker extends  \Infuso\ActiveRecord\Record
{
	
	public static function indexTest() {
        return true;
    }
	
	 public static function postTest() {
        return true;
    }

    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("title");
    }
	
	
    public  function index_item($p = null) {
        $speaker  = self::get($p["id"]);			
		app()->tm()->add("center", "/site/speakers/details",array(
            "speaker" => $speaker,
        ));
		app()->tm("/site/layout")->exec();
    }
	
	public function questions() {
        return Question::all()->asc("completed")->eq("speaker", $this->id());
    }

    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }

    public function masterclasses(){
        return Masterclass::all()->eq("speaker", $this->id());
    }
	
	public function materials(){
        return SpeakerMaterials::all()->eq("speaker", $this->id());
    }

	 /**
     * Возвращает коллекцию всех мастерклассов с данным спикером
     **/
    public function visibleMasterclasses() {
        return Masterclass::all()
            ->visible()
            ->eq("speaker",$this->id());
    }
    
    public function members_news() {
        return Member::all()
            ->eq("sp", $this->id());
    }
    
    /**
     * Возвращает коллекцию изображений мастерклассов для спикера
     **/         
    public function galleryForSpeaker() {
        return \Infuso\Site\Model\McPhotoGallery::all()
            ->join(\Infuso\Site\Model\Masterclass::all(), "mcID", "id")
            ->where("`Infuso\\Site\\Model\\Masterclass`.`speaker` = {$this->id()}")
            ->limit(0);
    }
   
    public static function model() {
        return array(
            'name' => 'speaker',
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'label' => 'ФИО преподавателя',
                    "editable" => 1,
                ), array (
                    'name' => 'avatar',
				    'type' => 'knh9-0kgy-csg9-1nv8-7go9',
				    'editable' => '1',
				    'label' => 'Портрет 107х107 px',
                ), array (
                    'name' => 'info',
                    'type' => 'html',
					'editable' => '1',
					'label' => 'Информация о преподавателе',
                ), array (
					'name' => 'advice',
					'type' => 'html',
					'editable' => '1',
					'label' => 'Совет',
                ), array (
					'name' => 'photo',
					'type' => 'knh9-0kgy-csg9-1nv8-7go9',
					'editable' => '1',
					'label' => 'Фотография для детальной страницы 566х376 px',
                ), array (
                    'name' => 'links',
					'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
					'editable' => '0',
					'label' => 'Ссылки на блоги',
                ), array (
                    'name' => 'video',
				    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				    'editable' => '1',
				    'label' => 'Видео с youtube.com',
				    'help' => 'Каждый ID на видео или ссылка с новой строке',
                ),
            ),
        );
    }
}