<? 

<div class='ddksfajhjz' data:task='{$task->id()}' style='height:100%;' >

    <table class='top' style='background: #ededed;width: 100%; table-layout: fixed;' >
        <tr>
            <td style='padding:10px;width:100%;'>
                exec("/board/shared/task-tools"); 
            </td>
            <td style='padding:10px;width:50px;vertical-align: middle;' >
                <span class='add-task' >еще</span>
            </td>
        </tr>
    </table>    

    exec("form");
    
    <div style='padding: 0 20px;' >
        exec("files");  
    </div>
    
   // exec("/board/shared/comments");   
    
    //exec("timeline");

</div>