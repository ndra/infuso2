<?

namespace infuso\ActiveRecord\Handler;     
use Infuso\Core;

class FileCleaner implements Core\Handler {

	/**
	 * @handler = infuso/deploy
	 **/
	public function onDeploy() {

        $folders = array();
        foreach(\Infuso\ActiveRecord\Record::classes() as $class) {
            $folders[] = (String) Core\File::get((new $class)->storage()->defaultFolder());
        }
        
        foreach(Core\File::get(app()->publicPath()."/files/")->dir() as $path) {
        
            $path = (String) $path;
            if(!in_array($path, $folders)) {
                app()->msg("Folder ". $path." is not associated with any class", true);
            }
        }

    }

}
