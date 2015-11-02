<?

namespace Infuso\Cms\Preview;

/**
 * Поведение для файла
 **/
class Behaviour extends \Infuso\Core\Behaviour {

    public function addToClass() {
        return "infuso\\core\\localfile";
    }
    
	/**
	 * Возвращает объект превью-генератора
	 **/
	public function preview($width = 100, $height = 100) {
	    
	    if(func_num_args()==0) {
	    	return new Generator($this->path());
		}
		
		if(func_num_args()==2) {
	    	return new Generator($this->path(), $width, $height);
	    }
		
	}

}
