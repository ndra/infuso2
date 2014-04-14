<?

namespace Infuso\Update;
use Infuso\Core;

/**
 * ����� ��� ������ � API github.com
 **/
class GitHub extends \Infuso\Core\Component {

	public function downloadFolder($params) {
	
		$obligatoryKeys = array(
		    "owner",
		    "repo",
		    "branch",
		    "path",
		    "dest",
		);
		
		foreach($obligatoryKeys as $key) {
		    if(!$params[$key]) {
		        throw new \Exception("Error in \\Infuso\\Update\\GitHub::downloadFolder(\$params): \$params[{$key}] missing");
		    }
		}
	
	    $url = "https://api.github.com/repos/:owner/:repo/:format/:branch";
	
	    $params["format"] = "zipball";

		$url = preg_replace_callback("/\:([a-z]+)/",function($match) use(&$params) {
		    $key = $match[1];
		    return $params[$key];
		},$url);
		
		$file = Core\File::http($url);
		$file->userAgent("Awesome-Octocat-App");
		$contents = $file->contents();
		$info = $file->info();
		
		if($info["http_code"] != 200 ) {
		
			$data = json_decode($contents,1);
			
			// $headers = $file->responseHeaders();

		    if(is_array($data)) {
				Throw new \Exception("Github code {$info['http_code']}: {$url} ".$data["message"]);
			} elseif(is_string($json)) {
			    Throw new \Exception("Github code {$info['http_code']} {$url} ".$json);
			} else {
			    Throw new \Exception("Github returns {$info['http_code']}");
			}
		}
		
		$zip = Core\File::tmp()."/1.zip";
		Core\File::get($zip)->put($contents);
		$this->extract($zip,$params["dest"],$params["path"]);
		
	}
	
	/**
	 * ��������� �� ������ $zip � ����� $dest �����, ��������������� ���� $path
	 **/
	public function extract($src,$dest,$path) {
	
	    $path = trim($path,"/");
	
	    $zip = new \ZipArchive();
	    $zip->open(Core\File::get($src)->native());
	    
	    $root = "";
	    for($i = 0; $i < $zip->numFiles; $i ++) {
	    
	    	$file = $zip->getNameIndex($i);
	    	$file = explode("/",trim($file,"/"));
	    	array_shift($file);
	    	if(!sizeof($file)) {
	    	    continue;
	    	}
	    	
	    	$file = implode("/",$file);
	    	
	    	if($file == $path) {
	    	    $root = $zip->getNameIndex($i);
	    	}
	    }
	    
	    for($i = 0; $i < $zip->numFiles; $i ++) {
	    	$file = $zip->getNameIndex($i);
	    	if(strpos($file,$root)===0) {
	    	    $name = $zip->getNameIndex($i);
	    	    $name = substr($name,strlen($root));
	    	    if($name) {
	    	    	$stat = $zip->statIndex($i);
	    	    	if($stat["crc"] != 0) {
	    	    	    $itemDest = Core\File::get($dest."/".$name);
	    	    		Core\File::mkdir($itemDest->up(),1);
	    	    		$itemDest->put($zip->getFromIndex($i));
	    	    	}
	    	    }
	    	}
	    	
	    }
	}


}
