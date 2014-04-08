<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class Autocomplete extends Widget {
    
     public function name() {
        return "Автокомплит поле с ajax";
    }
    
    public function fieldName($fieldName) {
        $this->param("fieldName", $fieldName);
        return $this;
    }
    
    public function hiddenFieldId($hiddenFieldId) {
        $this->param("hiddenFieldId", $hiddenFieldId);
        return $this;
    }
    
    public function fieldId($fieldId) {
        $this->param("fieldId", $fieldId);
        return $this;
    }
    
    public function serviceUrl($serviceUrl){
        $this->param("serviceUrl", $serviceUrl);
        return $this;    
    }
    
    public function value($value){
        $this->param("value", $value);
        return $this;    
    }
    
    public function title($title){
        $this->param("title", $title);
        return $this;        
    }
    
    public function execWidget() {
        \tmp::exec("/heapit/widgets/autocomplete", $this->param());    
    }
        
}