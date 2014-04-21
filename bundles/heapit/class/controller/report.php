<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class report extends Base {

    public function index_salesFunnel() {
        \tmp::exec("/heapit/reports/sales-funnel");
    }
        
}
