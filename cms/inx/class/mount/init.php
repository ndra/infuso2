<?

/**
 * Класс для компипяции компонентов inx
 **/
class inx_init implements \Infuso\Core\Handler {

	/**
	 * @handler = infusoInit
	 **/
	public function init() {
	
	    mod::msg("inx");
	
		// Очищаем папку
		//file::get("/inx/pub/")->delete(true);

		foreach(mod::service("bundle")->all() as $mod) {
			self::buildModule($mod->path());
        }

	}
	
	public static function generateBuildID() {
		file::get(mod::app()->publicPath()."/inx/build_id.txt")->put(rand());
	}

	public static function packFile($mod,$file) {
		$path = self::getModulePath($mod)."/".$file;
		$file = inx_mount_file::get($path);
		$file->compileChain();
		self::generateBuildID();
	}

	public static function getModulePath($mod) {
	    $conf = mod::service("bundle")->bundle($mod)->conf();
	    $path = $conf["inx"]["path"];
	    if(!$path) {
	        return null;
		}
	    return mod::service("bundle")->bundle($mod)->path()."/".$path;
	}

	public static function buildModule($mod) {
	
		$path = self::getModulePath($mod);
		
		if(!$path) {
			return;
		}
		
		foreach(file::get($path)->search() as $file) {
	    	if(!$file->folder()) {
	    		inx_mount_file::get($file->path())->compile();
			}
		}
	}

}
