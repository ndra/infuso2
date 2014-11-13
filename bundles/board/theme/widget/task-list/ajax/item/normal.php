<? 

$task = $item->task();

<div class='task i95bnu5fvm task-{$task->id()}' data:id='{$task->id()}' >

    <table>
        <tr>
        
            <td class='users' >
            
                $active = $task->activeCollaborators()->distinct("id");
            
                foreach($task->collaborators() as $user) {
                    $userpic = $user->userpic()->preview(16,16)->crop();
                    <div>
                        <img class='{in_array($user->id(),$active) ? "active" : ""}' src='{$userpic}' title='{$user->title()}' />
                    </div>
                }
            </td>
        
            <td class='project' ><a href='{$task->project()->url()}' >{$task->project()->title()}</a></td>
            <td class='id' >{$task->id()}</td>
            
            <td class='files' style='width:100px;' >
                foreach($task->storage()->files() as $file) {
                    $preview = $file->preview(32,32)->crop();
                    <div>
                        <img src='{$preview}' />
                    </div>
                }
            </td>
            
            <td class='text'>
                echo \util::str($task->text())->ellipsis(100);
            </td>
            <td class='time'>
                echo $task->timeSpent();
                if($progress = $task->timeSpentProgress()) {
                    echo " + ".round($progress / 3600, 2);
                }
                echo " / ".$task->timeScheduled();
            </td>
        </tr>
    </table>
    
</div>