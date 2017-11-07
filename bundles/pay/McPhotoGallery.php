<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Фото для мастерклассов
 **/
class McPhotoGallery extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array(
                'name' => "masterclass_gallery",
                'fields' => array (
                    array (
                        'name' => 'id',
                        'type' => 'jft7-kef8-ccd6-kg85-iueh',
                    ), array (
						'name' => 'mcID',
						'type' => 'pg03-cv07-y16t-kli7-fe6x',
						'label' => 'Мастеркласс',
						'class' => Masterclass::inspector()->className(),
					), array (
						'name' => 'priority',
						'type' => 'bigint',
						'label' => 'приоритет',
						"editable" => false,
					), array (
						'name' => 'photo',
						'type' => 'file',
						'label' => 'Фото',
						"editable" => true,
					), 
                ),
            );
    } 

	public function all() {
        return service("ar")
            ->collection(get_class())->asc("priority")->param("sort", true);
    }
    
    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }
	
	public function recordParent() {
        return $this->pdata("mcID");
    }

}
