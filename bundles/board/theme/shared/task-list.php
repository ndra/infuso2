<? 
<div class="task-list-zjnu1r2ofp">
    foreach($tasks as $task){
        
        <div class="task-item" href="{$task->url()}">
            
            <div class="sticker">
                $icon = $task->pdata("projectID")->data("icon");
                <div class="head" style="background-image: url($icon);">
                    echo $task->id()."&nbsp;".$task->pdata("projectID")->title();     
                </div>
                <div class="description">
                    <div class="wraper">{$task->data("text")}</div>
                    <div class="controls">
                        <div class="take"></div>
                        <div class="edit"></div>
                    </div>        
                </div>
                   
            </div>
            
            <div class="support-block">
                <div class="info">
                    $userPic = $task->pdata("responsibleUser")->userpic()->preview(16,16)->crop();
                    <img src="{$userPic}" align="absmiddle">&nbsp;
                    echo round($task->pdata("timeSpent"), 2)."&nbsp;/&nbsp;".round($task->pdata("timeScheduled"), 2);
                </div>
                <div class="controls">
                    <div class="button problems"></div>
                    <div class="button cancel"></div>            
                </div>
            </div>
                
        </div>
    }
</div>