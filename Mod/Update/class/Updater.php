<?

namespace Infuso\Update;

use Infuso\Core;

/**
 * Класс для обновления модулей
 **/
class Updater extends \Infuso\Core\Component {

	public function update($bundleName) {
	
		$bundle = Core\Mod::service("bundle")->bundle($bundleName);
		$conf = $bundle->conf();
		
		if($conf["update"]) {
		
		    Core\Mod::msg("Updating {$bundle->path()}");
		
		    $params = $conf["update"];
		    $tmpFolder = Core\File::tmp();
		    $params["dest"] = $tmpFolder;
			$hub = new \Infuso\Update\Github;
			$hub->downloadFolder($params);
			
			Core\File::get($bundle->path())->delete(true);
			$tmpFolder->rename($bundle->path());
		    
		} else {
		    Core\Mod::msg("skip {$bundle->path()}");
		}
	}

}
