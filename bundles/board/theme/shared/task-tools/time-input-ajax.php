<?

$users = $task->workflow()->distinct("userId");
$users = \Infuso\User\Model\User::all()->eq("id",$users);

<div class='w3T2t7XKGU' >
    <table>
        foreach($users as $user) {
            <tr>
                
                $time = $task->timeSpentProgress($user->id());
                
                <td>{$user->title()}</td>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->style("width", 50)
                        ->value(round($time/3600,2))
                        ->exec();
                </td>
            </tr>
        }
    </table>
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->exec();
    
</div>