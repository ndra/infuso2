<?

<table class='cZerRT306G' >
    <tr>
        <td>Пользователь</td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Textfield")
                ->fieldName("title")
                ->value($access->data("userId"))
                ->exec();
        </td>
    </tr>
    <tr>
        <td>Проект</td>
        <td>
            widget("Infuso\\Board\\Widget\\ProjectSelector")
                ->fieldName("url")
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