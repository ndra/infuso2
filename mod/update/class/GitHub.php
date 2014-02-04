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
	
	/**
	 * Делает запрос к гитхабу
	 **/
	public function query($url,$params = array()) {
	
	    $params += $this->params();
	
		$url = preg_replace_callback("/\:([a-z]+)/",function($match) use(&$params) {
		    $key = $match[1];
		    return $params[$key];
		},$url);
		
		$file = Core\File::http($url);
		$file->userAgent("Infuso-Update");
		$file->curlParam("CURLOPT_USERPWD", "xxx:x-oauth-basic");
		$file->curlParam("CURLOPT_HTTPAUTH", CURLAUTH_BASIC);
		$json = $file->contents();
		$data = json_decode($json,1);

		if($data["message"]) {
			throw new \Exception($url.": ".$data["message"]."\n".$data["documentation_url"]);
		}
		
		return $data;
		
	}

	public function tree($path = "") {
	
	    $path = trim($path,"/");
	    
	    if($path == "") {
			$data = $this->query("https://api.github.com/repos/:owner/:repo/contents/?ref=:branch");
			$heap = array();
			foreach($data as $file) {
			    $sha = $file["sha"];
			    echo $sha."<hr/>";
			    if($file["type"] == "dir") {
				    $data2 = $this->query("https://api.github.com/repos/:owner/:repo/git/trees/:sha?recursive=1",array("sha" => $sha));
				    foreach($data2["tree"] as $file2) {
				        $heap[] = $file2["url"];
				    }
				}
			}
			echo "<pre>";
			var_export($heap);
	    }
	    
	}
	

}
