<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class OrgList extends Widget {
    
    public function name() {
        return "Список организации";
    }
    
    public function execWidget() {
        tmp::exec("/site/widget/org-list", $this->param());    
    }
        
}