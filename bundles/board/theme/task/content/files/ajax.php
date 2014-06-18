<? 

<div class='wq01orrvbq' >

    if($task->storage()->files()->count()) {
        foreach($task->storage()->files() as $file) {
            <div class='file' >                
                <img src='{$file->preview(150,150)}' />
                <div class='delete' ></div>
                <div class='name' >{$file->name()}</div>
            </div>
        }
    } 
    
</div>