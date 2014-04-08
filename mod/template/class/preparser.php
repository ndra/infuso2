<?

namespace Infuso\Template;
use Infuso\Core;

class Preparser {

	private $lines = array();

	public function preparse($str) {

	    $lines = array();
	    $this->addLine();
	    $newLine = true;

		$tokens = @token_get_all($str);

		foreach($tokens as $token) {

		    if(is_array($token)) {

		        $add = false;

		        switch(token_name($token[0])) {

					default:
		                $this->addLexem($token[1]);
		                if(preg_match("/\n\s*$/",$token[1])) {
		                    $this->addLine();
		                    $add = true;
						} elseif(preg_match("/^\s*$/",$token[1])) {
		                    $add = $newLine;
						}

					    break;

					case "T_COMMENT":
					    $this->addLexem($token[1]);
					    $this->addLine();
					    $add = true;
						break;

				}

		    } else {

	            $this->addLexem($token);
	            if($newLine) {
	                if(preg_match("/^\s*\</",$token))
	                    $this->replaceTags();
	            }
	            $newLine = false;
		    }

		    if($add) {
		        $newLine = true;
		    } else {
				$newLine = false;
			}

		}

		$out = "<? namespace Infuso\\Template; \n use \Infuso\Core\Mod; \n use \User; ?".">";
		foreach($this->lines as $line) {

		    $str = $line["content"];
		    if($line["html"]) {
		        $str = self::processLine($str);
			}

		    $out.= $str;
		}

		return $out;

	}
	
	private static function processLine($str) {
	
	    $markers = array();
	    
	    $str = preg_replace_callback("/\{(.*)\}/",function($r) use (&$markers) {
	        $key = \util::id();
	        $markers[$key] = $r[1];
	        return $key;
		} , $str);
		
		preg_match("/^\s*/",$str,$m);
        $before = $m[0];
    	$str = $before.'echo "'.strtr(trim($str),array('"'=>'\"')).'";';
    	
    	foreach($markers as $id => $expr) {
    	    $str = preg_replace_callback("/$id/",function($r) use ($expr) {
				return '".('.$expr.')."';
    	    }, $str);
    	}
    	
    	return $str;
	}

	public function addLexem($str) {
	    $this->lines[sizeof($this->lines)-1]["content"].= $str;
	}

	public function addLine() {
	    $this->lines[] = array(
	        "content" => "",
		);
	}

	public function replaceTags() {
	    $this->lines[sizeof($this->lines)-1]["html"] = true;
	}

}
