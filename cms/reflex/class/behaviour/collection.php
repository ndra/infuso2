<?

namespace Infuso\Cms\Reflex\Behaviour;
use Infuso\Core;

/**
 * Класс-поведение для создения отборов и сортировок в каталоге
 **/ 
class Collection extends Core\Behaviour {

	public function behaviourPriority() {
	    return -1;
	}
	
	public function reflexApplyParams($params) {
	    $this->param("viewMode",$params["viewMode"]);
	}
	
	/**
	 * Возвращает шаблон списка элементов коллекции
	 **/
	public function reflexTemplate() {
	
		$class = $this->param("reflexEditorClass");
	    $modes = $this->editor()->viewModes();
	    $tmp = $modes[$this->param("viewMode")];
	    
		$tmp = \Infuso\Template\Tmp::get($tmp);
        $tmp->param("collection",$this);
        return $tmp;
	}

    /**
     * Возвращает редактор для виртуального элемента коллекции
     **/
    public final function editor() {

        $editorClass = $this->param("editor");
        $virtual = $this->virtual();
        $virtual->addBehaviour("infuso\\cms\\reflex\\behaviour\\activeRecord");

        if(!$editorClass) {
            $editorClass = get_class($virtual->editor());
        }    

        $editor = new $editorClass($virtual);

        return $editor;

    }

    /**
     * Устанавливает у коллекции класс-редактор
     **/
    public final function setEditor($class) {
        $this->param("editor",$class);
        return $this;
    }

    /**
     * Возвращает массив редакторов элементов
     **/
    public function editors() {

        $class = get_class($this->editor());

        $ret = array();
        foreach($this as $item) {
            $ret[] = new $class($item->id());
        }

        return $ret;

    }

}