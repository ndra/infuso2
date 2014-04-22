<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Report extends Base {

    public function index_salesFunnel() {
        \tmp::exec("/heapit/reports/sales-funnel");
    }
    
    public function index_payments() {
        \tmp::exec("/heapit/reports/payments");
    }
    
    public function index() {
        \tmp::exec("/heapit/reports");
    }
        
}
