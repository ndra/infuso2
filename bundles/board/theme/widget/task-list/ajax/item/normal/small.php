<?

$task = $item->task();

<div class='YXACajLyjN' >

    <table class='header' >
        <tr>
            if($group->sortable()) {
                <td class='sort-handle' >
                    <img src='{$this->bundle()->path()}/res/img/icons16/sort.png' style='opacity:.2;' />
                </td>
            }
            <td class='id' >{$task->id()}</td>
            <td class='project-icon' >
                $icon = $task->project()->icon()->preview(16,16);
                <img src='{$icon}' />
            </td>
            <td class='project' >{$task->project()->title()}</a></td>
           
            <td class='creator' >
                $icon = $task->pdata("creator")->userpic()->preview(16,16)->crop();
                <img src='{$icon}' />
            </td> 
            
            <td style='width:100%;' ></td>
            
             <td class='time'>
                echo round($task->timeSpent() / 3600, 2);
                if($progress = round($task->timeSpentProgress() / 3600, 2)) {
                    echo " + ".$progress;
                }
                echo " / ".$task->timeScheduled();
            </td>
            
            <td class='users' >
            
                $active = $task->activeCollaborators()->distinct("id");
            
                foreach($task->collaborators() as $user) {
                    $userpic = $user->userpic()->preview(16,16)->crop();
                    <div>
                        <img class='{in_array($user->id(),$active) ? "active" : ""}' src='{$userpic}' title='{$user->title()}' />
                    </div>
                }
            </td>
        </tr>
    </table>

    <div class='text'>
        $comment = $task->getLog()->eq("type", \Infuso\Board\Model\Log::TYPE_TASK_REVISED)->one();
        if($comment->exists()) {
            <span class='comment' >{$comment->message()}</span>
        }
        echo \util::str($task->text())->ellipsis(200);
    </div>

    <div class='files' >
        foreach($task->storage()->files() as $file) {
            $preview = $file->preview(32,32)->crop();
            <div>
                <img src='{$preview}' />
            </div>
        }
    </div>
        
</div>