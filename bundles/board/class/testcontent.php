<?

namespace Infuso\Board;
use Infuso\Core;

/**
 * Поведение для класса пользователя, добавляющее методы доски
 **/
class TestContent extends Core\Component {

    public function indexTest() {
        return Core\Superadmin::check();
    }
    
    public function index() {
        echo 123;
    }
    
}
