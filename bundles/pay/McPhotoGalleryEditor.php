<?

namespace Infuso\Site\Model;
use Infuso\Core;


class McPhotoGalleryEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return McPhotoGallery::inspector()->className();
    }
    
    public function availlableViewModes() {
        return array("thumbnail");
    }
          
    public function all() {
        return McPhotoGallery::all()->title("фотогалерея");
    }

}
