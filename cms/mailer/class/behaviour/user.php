<?

namespace Infuso\Cms\Mailer\Behaviour;
use Infuso\Core;

/**
 * Поведение для пользователя
 **/ 
class User extends Core\Behaviour {

    public static function addToClass() {
        return "Infuso\\User\\Model\\User";
    }

    /**
     * Возвращает коллекцию писем, отправленных пользователю
     **/
    public function emails() {
        return \Infuso\CMS\Mailer\Model\Mail::all()
            ->eq("user", $this->id());
    }

}
