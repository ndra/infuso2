<?

namespace Infuso\Board;
use Infuso\Core;

/**
 * ��������� ��� ������ ������������, ����������� ������ �����
 **/
class TestContent extends Core\Component {

    public function indexTest() {
        return Core\Superadmin::check();
    }
    
    public function index() {
        echo 123;
    }
    
}
