<?

namespace Infuso\Update;

use Infuso\Core;

class Updater extends \Infuso\Core\Component {

	public function update($mod) {
		$bundle = Core\Mod::service("bundle")->bundle($mod);
		$conf = $bundle->conf();
		if($conf["update"]) {
		    Core\Mod::msg($conf);
			Core\Mod::msg("update {$bundle->path()}");
		} else {
		    Core\Mod::msg("skip {$bundle->path()}");
		}
	}

}
