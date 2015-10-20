<?

namespace Infuso\Poll\Model;

class OptionEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Option::inspector()->className();
    }

}