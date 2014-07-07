<? 

<div class='ddksfajhjz' data:task='{$task->id()}' style='height:100%;' >

    <div class='top' style='padding:10px;background: #ededed;' >
        <table style='width:100%;table-layout:fixed;' >
            <tr>
                <td>
                    exec("/board/shared/task-tools");           
                </td>
                <td style='width:300px;vertical-align:middle;text-align:right;padding-right:20px;' >
                    exec("status");
                </td>
            </tr>
        </table>
        
    </div>    

    exec("form");
    
    <div style='padding: 0 20px;' >
        exec("files");  
    </div>
    
    exec("timeline");

    
    <div class='right' style='width:300px;border-left:1px solid #ccc;' >
        exec("/board/shared/comments");                
    </div>
    

                
</div>