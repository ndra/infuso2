<?

namespace Infuso\Update;

use Infuso\Core;

/**
 * Класс для работы с API github.com
 **/
class GitHub extends \Infuso\Core\Component {

	public function __construct($params) {
	    $this->params($params);
	}
	
	public function owner() {
	    return $this->param("owner");
	}
	
	public function repo() {
	    return $this->param("repo");
	}
	
	public function branch() {
	    return $this->param("branch");
	}

	public function tree() {
		$url = "https://api.github.com/repos/{$this->owner()}/{$this->repo()}/contents/{$path}?ref={$this->branch()}";
		$file = Core\File::http($url);
		$data = $file->contents();
		echo $data;
	}

}
