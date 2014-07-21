<? 

header();
lib::reset();
mod::coreJS();

$from = util::date($params["from"])->date();
$to = util::date($params["to"])->date();

<div style='padding:20px;' >

    <div style='position:absolute;right:20px;' >
        <input type='checkbox' id='display-subtasks' >
        <label for='display-subtasks' >Показать подзадачи</label>
    </div>
    
    <div style='margin-bottom:20px;' >
        echo "Отчет по проекту «{$project->title()}» {$from->text()} &mdash; {$to->text()}";
        <div style='opacity:.5;font-style:italic;font-size:.8em;' >
            echo "Показаны задачи, изменившие статус в указанный интервал. Подзадачи выводятся без ограничения по дате.";
        </div>
    </div>

    $tasks = $project->tasks()
        ->desc("changed")
        ->geq("date(changed)",$from)
        ->leq("date(changed)",$to);

    if(($tag = trim($params["tag"])) && $tag!="*") {
        $tasks->useTag($tag);
    }
        
    <table>
        <tr>
            <td>
				app()->tm("tasks")->param("tasks",$tasks)->exec();
            </td>
            <td style='padding-left:20px;' >
				app()->tm("../contributors")->param(array(
					"from" => $from,
                    "to" => $to,
                    "project" => $project,
				))->exec();
            </td>
        <tr>        
    </table>
</div>

footer();