<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;
use Infuso\Cms\Reflex;

/**
 * Основной контроллер каталога
 **/
class Route extends \Infuso\Core\Controller {

    /**
     * Разрешение для POST-команд
     **/
    public static function postTest() {
        return \user::active()->checkAccess("admin:showInterface");
    }

    /**
     * Контроллер создания мета-объекта
     **/
    public function post_create($p) {
        $editor = Reflex\Editor::get($p["editor"]);
        $item = $editor->item();
        $id = get_class($item).":".$item->id();
        $this->service("ar")->create(Reflex\Model\Route::inspector()->className(),array(
            "hash" => $id,
		));
    }


}