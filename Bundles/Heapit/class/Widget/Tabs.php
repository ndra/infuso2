<?

namespace Infuso\Heapit\Widget;
use Infuso\Template\Widget;

class Tabs extends Widget {

	private $tabStarted = false;
	
	private $tabName = "";
	
	private $tabs = array();
    
    public function name() {
        return "Табы";
    }
    
    public function tab($name) {
        $this->closeTab();
        $this->tabName = $name;
        $this->tabStarted = true;
        ob_start();
    }
    
    public function closeTab() {
        if($this->tabStarted) {
            $this->tabs[] = array(
                "title" => $this->tabName,
                "content" => ob_get_clean(),
			);
			$this->tabStarted = false;
        }
    }
    
	public function execWidget() {
	    $this->closeTab();
	    $this->param("tabs", $this->tabs);
        \tmp::exec("/heapit/widgets/tabs", $this->params());
    }

}
