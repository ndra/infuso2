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

    public function index_referrals() {
        \tmp::exec("/heapit/reports/referrals");
    }

    /**
     * Возвращает дланные для отчета по рефералам
     **/
    public function post_referralsData() {

        $ret = array(
            "nodes" => array(),
            "edges" => array(),
        );

        $orgs = \Infuso\Heapit\Model\Org::all()
            ->neq("referral", 0)
            ->limit(0);

        $added = array();
        $add = function($org) use (&$added) {
            $key = array_search($org->id(), $added);
            if($key === false) {
                $added[] = $org->id();
            }
            $key = array_search($org->id(), $added);
            return $key;
        };

        foreach($orgs as $org) {
            $source = $add($org);
            $target = $add($org->pdata("referral"));

            $ret["edges"][] = array (
                "source" => $source,
                "target" => $target,
            );

        }

        foreach($added as $n => $id) {
            $org = \Infuso\Heapit\Model\Org::get($id);
            $income = $org->payments()->sum("income");
            $ret["nodes"][] = array(
                //"title" => $org->title()." ".$income,
                "radius" => sqrt($income) / 30,
            );
        }

        return $ret;
    }

    public function index_clients() {
        \tmp::exec("/heapit/reports/clients");
    }

    /**
     * Возвращает дланные для отчета по рефералам
     **/
    public function post_clientsData() {


        $ret = array(
            "name" => "cluster",
            "children" => array(),
        );

        $payments = \Infuso\Heapit\Model\Payment::all()
            ->limit(0)
            ->joinByField("orgId")
            ->groupBy("orgId")
            ->gt("income", 0)
            ->where("year(date) in (2013,2014)")
            ->select("sum(`income`) as `sum` ,`Infuso\\Heapit\\Model\\Org`.`title` as `title`");

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
                "kmax" => $payment["sum"] / $max
            );
        }

        return $ret;
    }
    
    public function index() {
        \tmp::exec("/heapit/reports");
    }
        
}
