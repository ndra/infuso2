<?

$workDays = 0;
for($i = 0; $i < 30; $i ++) {
    $day = \util::now()->shiftDay(-$i)->commercialWeekDay();
    if($day >= 1 && $day <= 5) {
        $workDays ++;
    }
}
$workHours = $workDays * 8;

<div class='BDibMuP4fa' >
    <table>
        foreach(user::all()->withRole("board/worker") as $user) {
            
            $timeSpent = \Infuso\Board\Model\Workflow::all()
                ->eq("userId", $user->id())
                ->geq("begin", \Infuso\Util\util::now()->shiftday(-30))
                ->eq("status", 2)
                ->sum("duration");
                
            $timeSpent = round($timeSpent / 3600, 1);
            
            $percent = round($timeSpent / $workHours * 100);
            
            <tr>
            	<td>{$user->title()}</td>
            	<td>{$timeSpent}&nbsp;ч.</td>
            	<td>{$percent}%</td>
        	</tr>
        }
    </table>
</div>