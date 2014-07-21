<?

namespace Infuso\Cms\Reflex;

class editorWidget extends \Infuso\Template\widget {

	public function name() {
	    return "Редактор";
	}
	
	public function execWidget() {
	
	    $item = reflex::get($this->param("class"),$this->param("id"));

		if(!$item->editor()->beforeEdit()) {
		    return;
		}
		
		app()->tm("/reflex/admin/editWidget")->param("item",$item)->exec();
	}

}
