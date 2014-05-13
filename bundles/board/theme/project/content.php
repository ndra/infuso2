<? 

<div class='mp31n7wmn2' >    
    
    /*foreach($project->accesses() as $access) {
        <div>
            echo $access->user()->title();
        </div>
    } */
    
    <table>
        <tr>
            <td style='padding-right:40px;' >
                <h1 class='g-header' >{$project->title()}</h1>
                exec("form");
            </td>
            <td>
                exec("report");
                exec("tasks");
            </td>
        </tr>
    </table>
    


</div>