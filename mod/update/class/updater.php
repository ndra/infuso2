<?

namespace Infuso\Update;                          
use Infuso\Core;

/**
 * Класс для обновления модулей
 **/
class Updater extends Core\Component {

	public function update($bundleName) {
    
        $skip = $this->param("skip") ?: array();
        foreach($skip as $skip) {
            if(trim($skip, "/ ") == trim($bundleName, "/ ")) {
                app()->msg("{$bundleName} - disabled");
                return;
            }
        }
	
		$bundle = Core\Mod::service("bundle")->bundle($bundleName);
		$conf = $bundle->conf();
		
		if($conf["update"]) {
		
		    $params = $conf["update"];
		    $tmpFolder = Core\File::tmp();
		    $params["dest"] = $tmpFolder;
			$hub = new \Infuso\Update\Github;
			$hub->downloadFolder($params);
			
			Core\File::get($bundle->path())->delete(true);
			$tmpFolder->rename($bundle->path());
			app()->msg("{$bundle->path()} - update");
		    
		} else {
		    app()->msg("{$bundle->path()} - skip");
		}
	}

}
