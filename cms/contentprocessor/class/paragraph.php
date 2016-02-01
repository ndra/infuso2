<?

namespace Infuso\CMS\ContentProcessor;
use \Infuso\Core;

/**
 * Класс для разбиения html на параграфы
 **/
class Paragraph extends Core\Service {

	private $buffer = "";
	
	private $result = array(
	    ""
	);

	/**
	 * Список блочных тэгов
	 **/
	public static $blockTags = array(
		"address",
		"blockquote",
		"center",
		"div",
		"fieldset",
		"form",
		"h1",
		"h2",
		"h3",
		"h4",
		"h5",
		"h6",
		"hr",
		"isindex",
		"menu",
		"ol",
		"p",
		"pre",
		"table",
		"ul",
	);
	
	/**
	 * Список тэгов, закрывающие элементы которым не требуются
	 **/
	public static $optionalClosed = array(
	    "hr",
	);
	
	public function process($html) {
	
	    $array = self::getArray($html);
	    
	    $ret = "";
	    foreach($array as $item) {
	    
	        $item = trim($item);
	    
	        $p = true;
	        if(preg_match("/^<\s*(\w+)/",$item, $matches)) {
	            if(in_array($matches[1], self::$blockTags)) {
	                $p = false;
	            }
	        }
	        
	        if($p) {
	            $item = self::addParagraphs($item);
	        }
	        
	        $ret.= $item;
	        
	    }
	    return $ret;
	
	}
	
	private static function addParagraphs($html) {
	
        // Убираем пробелы около \n
        $html = explode("\n",$html);
        foreach($html as $key=>$val) {
            $html[$key] = trim($val);
        }
        $html = implode("\n",$html);
	
        // Заменяем две и более новых строки на две ровно
        $html = preg_replace("/\n{2,}/","\n\n",$html);

        $html = preg_split("/(\n\n)/Us",$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        
        foreach($html as $key => $val) {
            $val = trim($val,"\n");
            if($val) {
                $val = strtr($val,array(
                    "\n" => "<br/>",
                ));
                $val = "<p>".$val."</p>";
                $html[$key] = $val;
            } else {
                $html[$key] = "";
            }
        }
        
        $html = implode("",$html);
        return $html;
	
	}

	public function getArray($html) {
	
	    $gramma = array(
            "/^<!--(.*)-->/U" => "comment",
	        "/^<(\"[^\"]*\"|'[^']*'|[^'\">])*>/" => "tag",
	        "/^[^<]+/i" => "text",
		);
		
		while(strlen($html)) {
		    $found = false;
			foreach($gramma as $regex => $method) {
			    if(preg_match($regex, $html, $matches)) {
			        $mlen = mb_strlen($matches[0], "utf-8");
			        $slen = mb_strlen($html, "utf-8");
					$html = mb_substr($html, $mlen, $slen - $mlen, "utf-8");
			        $this->$method($matches[0]);
			        $found = true;
                    break;
			    }
			}
			if(!$found) {
			    throw new \Exception();
			}
		}
		
		return $this->result;
	}
	
	public function up() {
	    if($this->level == 0) {
	        $this->nl();
	    }
	    $this->level ++;
	}
	
	public function down() {
	    $this->level --;
		if($this->level == 0) {
	        $this->nl();
	    }
	}
	
	public function write($html) {
	    $this->result[sizeof($this->result) - 1] .= $html;
	}
	
	public function nl() {
	    if($this->result[sizeof($this->result) - 1] != "") {
	    	$this->result[] = "";
	    }
	}
	
	public function text($text) {
	    $this->write($text);
	}
    
	public function comment($comment) {
	    //$this->write($text);
	}
	
	public function tag($tag) {
	
	    // Определяем ипя элемента
		preg_match("/\w+/", $tag, $matches);
		$name = $matches[0];
		
		if(!in_array($name, self::$blockTags)) {
		    $this->write($tag);
		    return;
		}

		// Определяем тип тэга
		$close = preg_match("/^<\s*\//", $tag);
		$selfClosed = preg_match("/\/\s*>$/", $tag);
		$open = !$close && !$selfClosed;
	
	    if($close) {
			$this->write($tag);
			if(!in_array($name, self::$optionalClosed)) {
				$this->down();
			}
			if($this->level == 0) {
			    $this->nl();
			}
	    }
	    
	    if($open) {
        	$this->up();
         	$this->write($tag);
			if(in_array($name, self::$optionalClosed)) {
			    $this->down();
			}
	    }
	    
		if($selfClosed) {
		    $this->up();
	        $this->write($tag);
	        $this->down();
	    }
	}

}
