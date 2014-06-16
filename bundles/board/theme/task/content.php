<? 

<div class='ddksfajhjz' data:task='{$task->id()}' style='height:100%;' >

    <div class='center' style='overflow:auto;padding: 30px;' >    
        exec("status");
        <br/>
        exec("form");                
        exec("/board/shared/task-tools");
        <br/>
        exec("timeline");
        <br/>
        exec("files");            
    </div>
    
    <div class='right' style='width:300px;border-left:1px solid #ccc;' >
        exec("comments");                
    </div>
                
</div>