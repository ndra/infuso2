<?

<table class='cZerRT306G' >
    <tr>
        <td>Пользователь</td>
        <td>
            widget("Infuso\\Board\\Widget\\UserSelector")
                ->fieldName("userId")
                ->value($access->data("projectId"))
                ->exec();
        </td>
    </tr>
    <tr>
        <td>Проект</td>
        <td>
            widget("Infuso\\Board\\Widget\\ProjectSelector")
                ->fieldName("projectId")
                ->value($access->data("projectId"))
                ->exec();
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Button")
                //->text($project->exists() ? "Сохранить" : "Создать")
                ->attr("type", "submit")
                ->exec();
        </td>
    </tr>
</table>