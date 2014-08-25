<?

namespace Infuso\Cms\Mailer\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель записи в журнале
 **/ 
class TemplateEditor extends \Infuso\CMS\Reflex\Editor {

	public function itemClass() {
		return Template::inspector()->className();
	}

    /**
     * @reflex-root = on
     **/         
    public static function all() {
        return Template::all()->title("Шаблоны писем");
    }

    /**
     * @reflex-child = on
     **/         
    public function emails() {
        return $this->item()->emails()->title("Письма с этим кодом");
    }

}
