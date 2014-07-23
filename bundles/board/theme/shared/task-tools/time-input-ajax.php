<?

$users = $task->workflow()->distinct("userId");
$users = \Infuso\User\Model\User::all()->eq("id",$users);

<form class='w3T2t7XKGU' data:task='{$task->id()}' >

    <table>
        foreach($users as $user) {
            <tr>
                
                $time = $task->timeSpentProgress($user->id());
                $userpic = $user->pdata("userpic")->preview(32,32)->crop();
                
                <td>{$user->title()}</td>
                <td><img src='{$userpic}' /></td>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->style("width", 50)
                        ->fieldName($user->id())
                        ->value(round($time/3600,2))
                        ->exec();
                </td>
            </tr>
        }
    </table>
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->attr("type", "submit")
        ->style("margin-top", 20)
        ->exec();
    
</form>