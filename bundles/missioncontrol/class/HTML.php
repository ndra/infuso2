<?

namespace Infuso\Missioncontrol;
use \Infuso\Core;

/**
 * Класс для работы c html
 **/
class HTML implements \Iterator {
	
    private $xml;
    
    private static $container = "flp9ru3zr4gvh7nsb5zjv8n";
    
    public function rewind() { reset($this->xml); }
    public function current() {
        $ret = current($this->xml);
        if($ret !== false) {
            $ret = new self($ret); 
        }
        return $ret;
    }
    public function key() { return key($this->xml); }
    public function next() { return next($this->xml); }
    public function valid() { return $this->current() !== false; }

    public function __construct($input) {   
    
        $container = self::$container;
     
        if(is_string($input)) {
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML("<meta http-equiv='Content-type' content='text/html; charset=utf-8' /><div><{$container}>{$input}</{$container}></div>");
            libxml_clear_errors();
            $this->xml = array(
                simplexml_import_dom($doc)->body->div->$container,
            );
        } elseif(is_array($input)) {
            foreach($input as $item) {
                if(get_class($item) != "SimpleXMLElement") {
                    throw new \Exception("HTML::__construct if argument is array it mus have elements of class SimpleXMLElement");
                }
            }
            $this->xml = $input;
        } elseif (get_class($input) == "DOMElement") {
            $this->xml = array(
                simplexml_import_dom($input),
            );      
        } elseif (get_class($input) == "SimpleXMLElement") {
            $this->xml = array(
                $input,
            );      
        } else {
            throw new \Exception("Wrong argument ".gettype($input)." ".get_class($input));
        }           
    }
    
    public function __toString() {
        $ret = array();
        foreach($this->xml as $item) {
            $item = $item->asXML();
            $container = self::$container;
            $item = preg_replace("/^\<{$container}\>/", "", $item);
            $item = preg_replace("/\<\/{$container}\>$/", "", $item);
            $ret[] = $item;
        }
        return implode(",", $ret);
    }
    
    public function xpath($xpath) {
        $ret = array();
        foreach($this->xml as $item) {
            foreach($item->xpath($xpath) as $xpathResult) {
                $ret[] = $xpathResult;
            }                           
        }
        return new self($ret);
    }
    
    public function attr($key = null, $val = null) {
    
        if(func_num_args() == 0) {
            $ret = array();
            foreach($this->xml[0]->attributes() as $key => $val) {
                $ret[$key] = $val;
            }
            return $ret;
        }    
        
        if(func_num_args() == 1) {
            return $this->xml[0]->attributes()[$key];
        }    
    
        // Изменяем атрибут
     
        if(func_num_args() == 2) {
            foreach($this->xml as $item) {
            
                if($val === null) {
                    unset($item->attributes()[$key]);
                } else {                
                    if(!isset($item->attributes()[$key])) {
                        $item->addAttribute($key, $val);
                    } else {
                        $item->attributes()[$key] = $val;
                    }
                }
            }
            return $this;
        }    
    }
    
    /**
     * Заменяет выбранные элементы на $replacement
     **/         
    public function replaceWith($replacement) {
    
        $replacement = new self($replacement);
    
        foreach($this->xml as $item) {        
        
            $parent = $item->xpath("parent::*")[0];
            if($parent !== null) {
                $doc = dom_import_simplexml($parent);
                $newChildren = array();
                foreach($doc->childNodes as $child) {
                    if($child->isSameNode(dom_import_simplexml($item))) {
                        foreach(dom_import_simplexml($replacement->xml[0])->childNodes as $replacementChild) {
                            $newChildren[] = $replacementChild;
                        }
                    } else {
                        $newChildren[] = $child;
                    }
                }
                
                while ($doc->childNodes->length > 0) {
                    $doc->removeChild($doc->childNodes->item(0));
                }
                
                foreach($newChildren as $child) {
                    $imported = $doc->ownerDocument->importNode($child, true);
                    $doc->appendChild($imported);
                }                
            }
            
        }
    }
    
    public function length() {
        return sizeof($this->xml);
    }
    
    public function first() {
        return new self($this->xml[0]);
    }
    
    public function name() {
        return $this->xml[0]->getName();
    }
    
    public function innerHTML() {
    
        if(sizeof($this->xml) == 0) {
            return "";
        }
    
        $innerHTML = ""; 
        $element = dom_import_simplexml($this->xml[0]);
        $children = $element->childNodes;      
        foreach ($children as $child) { 
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }     
        return $innerHTML; 
    }
    
    public function domChildren() {
        $ret = array();
        foreach($this->xml as $node) {
            $dom = dom_import_simplexml($node);
            foreach($dom->childNodes as $child) {
                $ret[] = $child;
            }
        }
        return $ret;
    }
   
}
