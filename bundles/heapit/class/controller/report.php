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

    public function index_clients() {
        \tmp::exec("/heapit/reports/clients");
    }

    /**
     * Возвращает дланные для отчета по рефералам
     **/
    public function post_clientsData($data) {

        $ret = array(
            "name" => "cluster",
            "children" => array(),
        );

        foreach(array("income", "expenditure") as $type) {

            if($data["filter"][$type] == true) {

                $payments = \Infuso\Heapit\Model\Payment::all()
                    ->limit(0)
                    ->joinByField("orgId")
                    ->groupBy("orgId")
                    ->gt($type, 0) // income или expenditure
                    ->eq("year(date)", $data["filter"]["years"])
                    ->select("sum(`$type`) as `sum` ,`Infuso\\Heapit\\Model\\Org`.`title` as `title`");

                $sum = 0;
                $max = 0;
                array_map(function($item) use (&$sum,&$max) {
                    $sum += $item["sum"];
                    $max = max($max, $item["sum"]);
                }, $payments);

                foreach($payments as $payment) {
                    $ret["children"][] = array(
                        "title" => $payment["title"],
                        "value" => round($payment["sum"] / 1000),
                        "total" => round($payment["sum"] / 1000),
                        "percent" => round($payment["sum"] / $sum * 100, 2),
                        "kmax" => $payment["sum"] / $max,
                        "type" => $type,
                    );
                }

            }

        }

        return $ret;
    }
    
    public function index() {
        \tmp::exec("/heapit/reports");
    }
        
}
