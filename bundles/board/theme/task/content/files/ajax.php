<? 

<div class='wq01orrvbq' data:task='{$task->id()}' >

    if($task->storage()->files()->count()) {
        foreach($task->storage()->files() as $file) {
            
            $id = $file->rel($task->storage()->path());
            
            <div class='file' data:id='{$id}' >                
                <img src='{$file->preview(150,150)}' />
                <div class='delete' ></div>
                <div class='name' >{$file->name()}</div>
            </div>
        }
    } 
    
</div>