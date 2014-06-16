<?

<table class='QeaI04R5nl' >
    <tr>
        <td>Название проекта</td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Textfield")
                ->fieldName("title")
                ->value($project->data("title"))
                ->exec();
        </td>
    </tr>
    <tr>
        <td>Адрес сайта</td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Textfield")
                ->fieldName("url")
                ->value($project->data("url"))
                ->exec();
        </td>
    </tr>
    <tr>
        <td>Автоматически закрывать задачи через</td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Textfield")
                ->style("width", 50)
                ->fieldName("completeAfter")
                ->value($project->data("completeAfter"))
                ->exec();
                
            <span style='font-style:italic; color: gray;' >дней</span>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            widget("Infuso\\CMS\\Ui\\Widgets\\Button")
                ->text($project->exists() ? "Сохранить" : "Создать")
                ->attr("type", "submit")
                ->exec();
        </td>
    </tr>
</table>