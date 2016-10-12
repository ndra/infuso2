<?

admin::header();
<div class='y1YrXY3WM1' >

<div>Данные за последние 24 часа</div>
<br>

$items = \Infuso\MissionControl\Model\ServerStatusLog::all()
    ->geq("datetime", \Infuso\Util\Util::now()->shiftDay(-1))
    ->limit(100);
$pages = $items->pages();

$hosts = array();
$ips = array();
$urls = array();

$n = 0;
for($i = 1; $i <= $pages; $i ++) {
    foreach($items->copy()->page($i) as $item) {
        $log = json_decode($item->data("log"), true);
        foreach($log as $logItem) {
            
            if($_REQUEST["ip"] && $_REQUEST["ip"] != $logItem["ip"]) {
                continue;
            } 
            
            if($_REQUEST["host"] && $_REQUEST["host"] != $logItem["host"]) {
                continue;
            } 
            
            $hosts[$logItem["host"]] += $logItem["cpu"] * 1;
            $ips[$logItem["ip"]] += $logItem["cpu"] * 1;
            $urls[$logItem["path"]] += $logItem["cpu"] * 1;
        }
        $n ++;
    }
}

// Нормируем
foreach($hosts as $key => $val) {
    $hosts[$key] /= $n;
}
foreach($ips as $key => $val) {
    $ips[$key] /= $n;
}
foreach($urls as $key => $val) {
    $urls[$key] /= $n;
}

asort($hosts);
$hosts = array_reverse($hosts);

asort($ips);
$ips = array_reverse($ips);

asort($urls);
$urls = array_reverse($urls);

<h2>Нагрузка по хостам</h2>
<table>
foreach($hosts as $name => $cpu) {
    <tr>
        <td><a href='?host={$name}' >{$name}</a></td>
        <td>{round($cpu, 2)} %</td>
    </tr>
}
</table>

<h2>Нагрузка по ip</h2>
<table>
foreach($ips as $name => $cpu) {
    <tr>
        <td><a href='?ip={$name}' >{$name}</a></td>
        <td>{round($cpu, 2)} %</td>
    </tr>
}
</table>

<h2>Нагрузка по URL</h2>
<table>
foreach($urls as $name => $cpu) {
    <tr>
        <td>{$name}</td>
        <td>{round($cpu, 2)} %</td>
    </tr>
}
</table>

admin::footer();
