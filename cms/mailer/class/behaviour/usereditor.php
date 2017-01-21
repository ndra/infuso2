<?

namespace Infuso\CMS\Mailer\Behaviour;
use Infuso\Core;

/**
 * Поведение для редактора пользователя
 **/ 
class UserEditor extends Core\Behaviour {

    public static function addToClass() {
        return "Infuso\\CMS\\User\\UserEditor";
    }

    /**
     * Возвращает коллекцию писем, отправленных пользователю
     * @reflex-child = on
     **/
    public function emails() {
        return $this->item()->emails()->title("Письма");
    }

}
