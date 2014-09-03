<?

<div class='hSPlyiV6sp' >
    
    $groups = \Infuso\Board\Model\Task::all()
        ->visible()
        ->eq("parent", 0)
        ->eq("status", \Infuso\Board\Model\Task::STATUS_BACKLOG)
        ->eq("group", 1);
        
    foreach($groups as $group) {
        
        $n = $group->subtasks()
            ->eq("status", \Infuso\Board\Model\Task::STATUS_BACKLOG)
            ->count();
            
        <span class='group' data:group='{$group->id()}' >{$group->title()}
        
        if($n) {
            <span class='count'>{$n}</span>            
        }
        
        </span>
    }
    
    
</div>