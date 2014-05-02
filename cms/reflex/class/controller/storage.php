<?

namespace Infuso\Cms\Reflex\Controller;
use \infuso\Core;

/**
 * Основной контроллер каталога
 **/
class Storage extends Core\Controller {

	public function postTest() {
	    return true;
	}
	
	/**
	 * Возвращает контент для окна файлменеджера
	 **/
	public function post_getWindow($p) {
	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
	    $tmp = \Infuso\Template\Tmp::get("/reflex/storage");
	    $tmp->param("editor",$editor);
	    return $tmp->getContentForAjax();
	}

	public function post_getFiles($p) {

	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
	    $tmp = \Infuso\Template\Tmp::get("/reflex/storage/files-ajax");
	    $tmp->param("editor",$editor);
	    return array(
	        "html" => $tmp->getContentForAjax(),
		);

	}

	/**
	 * @todo проверка безопасности
	 **/
	public function post_upload($p) {
	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
	    $storage = $editor->item()->storage();
	    $storage->addUploaded($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
	}
   
}
