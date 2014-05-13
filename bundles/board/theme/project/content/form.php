<? 

<form class='eud8rxwk3d' data:project='{$project->id()}' >
    <table>
        <tr>
            <td>Название проекта</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->fieldName("title");
                $w->value($project->data("title"));
                $w->exec();                
            </td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->fieldName("url");
                $w->value($project->data("url"));
                $w->exec();                
            </td>
        </tr>
        <tr>
            <td>Закрывать задачи через</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->fieldName("completeAfter");
                $w->value($project->data("completeAfter"));
                $w->style("width",30);
                $w->exec();    
                <span>дней</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Button();
                $w->text("Сохранить");
                $w->attr("type", "submit");
                $w->exec();
            </td>
        </tr>
    </table>        
</form>
