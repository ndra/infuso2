<?

namespace Infuso\Cms\Mailer\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель записи в журнале
 **/ 
class MailEditor extends \Infuso\CMS\Reflex\Editor {

	public function itemClass() {
		return Mail::inspector()->className();
	}

    /**
     * @reflex-root = on
     **/         
    public static function all() {
        return Mail::all()->title("Письма");
    }

}
