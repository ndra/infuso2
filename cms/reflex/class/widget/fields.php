<?

namespace Infuso\Cms\Reflex\Widget;
use Infuso\Core;

/**
 * Виджет вывода полей (формы) для каталога
 **/
class Fields extends \Infuso\Template\Widget {

    private $fields;
    private $editor;

    public function name() {
        return "Поля";
    }
    
    public function fields($fields) {
        $this->fields = $fields;
        return $this;
    }
    
    public function editor($editor) {
        $this->editor = $editor;
        return $this;
    }
    
    public function execWidget() {
        app()->tm("/reflex/widget/fields")
            ->param("fields", $this->fields)
            ->param("editor", $this->editor)
            ->exec();
    }

}
