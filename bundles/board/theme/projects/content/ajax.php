<? 

$projects = \Infuso\Board\Model\Project::all()->limit(0);

<div class='hek1b6stnl' >
    <table>
    
        <thead>
            <tr>
                <td colspan='2' >Проект</td>
                <td>Сайт</td>
                <td>Автозакрытие задач</td>
            </tr>
        </thead>
    
        foreach($projects as $project) {
            <tr>
                $icon = $project->pdata("icon")->preview(16,16);
                <td><img src='{$icon}' ></td>            
                <td><a href='{$project->url()}' >{$project->title()}</a></td>
                <td>{$project->data("url")}</td>
                <td>{$project->data("completeAfter")}</td>
            </tr>
        }
    </table>
</div>