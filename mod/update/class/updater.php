<?

namespace Infuso\Update;

use Infuso\Core;

/**
 * Класс для обновления модулей
 **/
class Updater extends \Infuso\Core\Component {

	public function update($bundleName) {
    
        $skip = $this->param("skip") ?: array();
        foreach($skip as $key => $val) {
            if(trim($skip, "/") == trim($bundleName, "/")) {
                app()->msg("skip {$bundleName} - disabled");
            }
        }
	
		$bundle = Core\Mod::service("bundle")->bundle($bundleName);
		$conf = $bundle->conf();
		
		if($conf["update"]) {
        
            app()->msg($bundleName);
            return;
		
		    app()->msg("Updating {$bundle->path()}");
		
		    $params = $conf["update"];
		    $tmpFolder = Core\File::tmp();
		    $params["dest"] = $tmpFolder;
			$hub = new \Infuso\Update\Github;
			$hub->downloadFolder($params);
			
			Core\File::get($bundle->path())->delete(true);
			$tmpFolder->rename($bundle->path());
		    
		} else {
		    app()->msg("skip {$bundle->path()} - no update info");
		}
	}

}
