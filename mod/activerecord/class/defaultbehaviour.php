<?

/**
 * todo тотально рефакторить класс
 **/
class reflex_defaultBehaviour extends \Infuso\Core\Behaviour {

    public function behaviourPriority() {
        return - 1000;
    }

	/**
	 * @return Функция должна вернуть url объекта
	 * По умолчанию, url объекта имеет вид /my_class_name/item/id/123
	 * Переопределите функцию, если у элемента должен быть другой url
	 **/
	public function recordUrl() {
		return null;
	}

	/**
	 * @return Функция должна вернуть родительский элемент
	 * Это должен быть существующий или не существующий объект reflex, либо null
	 * Родитель используется в каталоге для построения пути к объекту
	 **/
	public function recordParent() {
		return reflex::get("reflex_none",0);
	}

	public function recordTitle() {
	
        if(!$this->exists()) {
			return "";
		}
		
		if($field = $this->recordTitleField()) {
        	if($title = $this->data($field)){
	            return $title;
	        }
        }
        
        return get_class($this).":".$this->id();
    }

    public function recordTitleField() {
        // перебираем поля до первого поля с именем title
        foreach($this->fields() as $field) {
            if($field->name()=="title") {
                return $field->name();
            }
        }
        // перебираем поля до первого поля сторокогвого типа и возвращаем его имя
        foreach($this->fields() as $field){
            if($field->typeID() == "v324-89xr-24nk-0z30-r243"){
                return $field->name();    
            }
        }
        
        return false;
    }

	/**
	 * Триггер, вызывающийся перед каждой поперацией создания, изменения или удаления
	 **/
	public function beforeOperation() {
	}

	/**
	 * Триггер, вызывающийся после каждой поперацией создания, изменения или удаления
	 **/
	public function afterOperation() {
	}


}
