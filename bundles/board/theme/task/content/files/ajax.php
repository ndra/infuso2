<? 

<div class='wq01orrvbq' >

    if($task->storage()->files()->count()) {
        foreach($task->storage()->files() as $file) {
            <div class='file' >                
                <img src='{$file->preview(200,200)}' />
                <div class='delete' ></div>
                <div class='name' >{$file->name()}</div>
            </div>
        }
    } else {
        <div class='no-files'>К задаче не приложены файлы</div>
    }
    
</div>