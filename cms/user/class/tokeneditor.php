<?

namespace Infuso\Cms\User;
use \Infuso\Core;
use \Infuso\ActiveRecord;
use \Infuso\User;

class TokenEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return User\Model\Token::inspector()->className();
	}
    
	public function listItemTemplate() {
	    return app()->tm("/user/token-list-item")
			->param("editor", $this);
	}

}
