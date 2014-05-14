<? 

<div class='ddksfajhjz' data:task='{$task->id()}' >

    <table>
        <tr>
            <td>
                exec("status");
                <br/>
                exec("form");                
                exec("/board/shared/task-tools");
                <br/>
                exec("timeline");
                <br/>
                exec("files");            
            </td>
            <td>
                exec("comments");
            </td>
        </tr>
    </table>
</div>