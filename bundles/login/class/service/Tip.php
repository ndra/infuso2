<?

namespace Infuso\Site\Service;
use Infuso\Core;

/**
 * Хэндлер для всяких штук
 **/
class Tip extends Core\Service {

    public function defaultService() {
        return "tip";
    }
    
    public function get($name, $label = null) {
        $tip = \Infuso\Site\Model\Tip::all()
            ->eq("name", $name)
            ->one();
        if(!$tip->exists()) {
            $tip = service("ar")->create("\Infuso\Site\Model\Tip", array("name" => $name));
        }
        if($label) {
            $tip->data("label", $label);
        }
        return $tip->data("text");
    }

}
