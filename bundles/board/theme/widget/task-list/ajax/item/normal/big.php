<?

$task = $item->task();

<table class='HuwF3NRfi1' >
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
       
        <td class='project-icon' >
            $icon = $task->pdata("creator")->userpic()->preview(16,16)->crop();
            <img src='{$icon}' />
        </td>           
        
            
        foreach($task->storage()->files() as $file) {
            <td class='file' >
                $preview = $file->preview(32,32)->crop();
                <div>
                    <img src='{$preview}' />
                </div>
            </td>
        }

        <td class='text'>
            $comment = $task->getLog()->eq("type", \Infuso\Board\Model\Log::TYPE_TASK_REVISED)->one();
            if($comment->exists()) {
                <span class='comment' >{$comment->message()}</span>
            }
            echo \util::str($task->text())->ellipsis(200);
        </td>
        
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
        
        <td class='sticker' >
            if($task->hangDays()) {
                <div class='hang' >
                    echo $task->hangDays();
                </div>
            }
        </td>
        
    </tr>
</table>