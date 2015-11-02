<? 

admin::header("Лог крона");

$log = service("log")->all()
    ->limit(0)
    ->eq("type","cron")
    ->eq("date(datetime)", \util::now()->date());
    
$data = $log->groupby("HOUR(datetime)")
    ->select("HOUR(datetime) as `time`, count(*) as `count`, round(min(`p1`),2) as `min`, round(max(`p1`),2) as `max`, round(avg(`p1`),2) as `avg`");

<div style='padding:20px;' >
    <table class='x618enltmoz' >
    
        <thead>
            <tr>
                <td>Время</td>
                <td>min</td>
                <td>max</td>
                <td>avg</td>
                <td>count</td>
            </tr>
        </thead>
    
        foreach($data as $row) {
            <tr>
                $time = $row["time"];
                <td>{$time}</td>
                <td>{$row[min]}</td>
                <td>{$row[max]}</td>
                <td>{$row[avg]}</td>
                <td>{$row[count]}</td>
            </tr>        
        }
    </table>
</div>

admin::footer();