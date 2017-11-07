<?

namespace Infuso\Site\Model;
use Infuso\Core;

class VideoCourseEditor extends \Infuso\CMS\Reflex\Editor
{
    public function itemClass() {
        return Videocourse::inspector()->className();
    }

	/**
     * @reflex-root = on
     * @reflex-group = Мастер-классы 
     **/
    public function all() {
        return Videocourse::all()->title("Видеокурсы");
    }
    
    public function metaEnabled() {
        return true;
    }  
}