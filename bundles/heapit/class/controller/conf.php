<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Conf extends Base {
    
    public function index() {
        $this->app()->tmp()->exec("/heapit/conf");
    }

    /**
     * Контроллер сохранения настроек
     **/
    public function post_save($p) {
        $user = \User::active();
        $user->data("nickName", $p["data"]["nickName"]);
        app()->msg("настройки сохранены");
    }

    /**
     * Контроллер сохранения юзерпика
     **/
    public function post_userpic($p) {
        $name = $_FILES["file"]["name"];
        $ext = Core\File::get($name)->ext();
        $ext = strtolower($ext);

        if($ext != "jpg") {
            app()->msg("Файл должен иметь расширение jpg");
            return;
        }

        $user = \User::active();
        $file = $user->storage()->addUploaded($_FILES["file"]["tmp_name"], "userpic.jpg");
        $user->data("userpic", $file);

        return \tmp::get("/heapit/conf/content/userpic/ajax")
            ->getContentForAjax();
    }
        
}
