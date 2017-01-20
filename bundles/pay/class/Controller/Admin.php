<?

namespace Infuso\Pay\Controller;
use Infuso\Core;
use Infuso\User\Model\User as User;

class Admin extends Core\Controller
{
    public function indexTest() {
        return true;
    }

    public function postTest() {
        return true;
    }

    public function index_reportInvoices() {

        if(!app()->user()->checkAccess("pay:viewReportInvoices")) {
            throw new Exception("Просмотр отчета недоступен");
        }

        exec("/pay/admin/reportInvoices");
    }

    public function post_addFunds($p) {
        $user = user::get($p["userID"]);
        $amount = $p["amount"] * 1;
        $user->addFunds($amount,"Пополнение счета администратором");
    }
}