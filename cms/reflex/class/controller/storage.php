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
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
	    $tmp = app()->tm("/reflex/storage");
	    $tmp->param("editor",$editor);
	    return $tmp->getContentForAjax();
	}

	public function post_getFiles($p) {
	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $storage = $editor->item()->storage();
        $storage->setPath($p["path"]);
        $tmp = app()->tm("/reflex/storage/files-ajax");
	    $tmp->param("storage",$storage);
	    return array(
	        "html" => $tmp->getContentForAjax(),
		);
	}

	/**
	 * Закачивает файл в хранилище для объекта
	 **/
	public function post_upload($p) {

	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
	    $storage = $editor->item()->storage();        
        $storage->setPath($p["path"]);
        
        $path = null;
        foreach($_FILES as $file) {
	       $path = $storage->addUploaded($file["tmp_name"],$file["name"]);
        }
        
	    if($path) {
            return array(
                "filename" => $path,
                "preview150" => (String) \Infuso\Core\File::get($path)->preview(150,150)->fit(),
            );
        }
	}

    /**
     * Контроллер удаления файла
     **/         
    public function post_delete($p) {

	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
	    $storage = $editor->item()->storage();
        foreach($p["items"] as $file) {
            $storage->delete($file);
        }
        app()->msg("Файлы удалены");
    }

    public function post_createFolder($p) {
	    $editor = \Infuso\Cms\Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
	    $storage = $editor->item()->storage();
        $storage->setPath($p["path"]);
        $storage->mkdir($p["name"]);
    }
   
}
