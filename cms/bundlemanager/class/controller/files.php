<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/

class Files extends Core\Controller {

	public function postTest() {
        return \Infuso\Core\Superadmin::check();
	}

    /**
     * Возвращает правый блок для выбранного бандла (с деревом файлов и кнопками)
     **/  	
	public function post_right($p) {
		return app()->tm("/bundlemanager/files-right")
            ->param("bundle",service("bundle")->bundle($p["bundle"]))
            ->getContentForAjax();
	}
    
    /**
     * Возвращает список файлов
     **/         
	public function post_list($p) {    
		return app()->tm("/bundlemanager/files-right/nodes")
            ->param("path", \file::get($p["id"]))
            ->getContentForAjax();
	}
    
    /**
     * Возвращает редактор файла
     **/  
    public function post_editor($p) {
		return app()->tm("/bundlemanager/file-editor")
            ->param("path", \file::get($p["path"]))
            ->getContentForAjax();
    }
    
    public function post_save($p) {
        Core\File::get($p["path"])->put($p["content"]);
        app()->msg("Файл изменен");
    }

}
