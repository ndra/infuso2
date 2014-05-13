<? 

<div class='faqficjvlh' >
    foreach($project->tasks() as $task) {
        <div>{$task->id()}. <a href='{$task->url()}' >{$task->title()}</a></div>
    }
</div> 