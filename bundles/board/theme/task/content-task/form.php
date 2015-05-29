<?

<form class='ybslv95net' data:task='{$task->id()}' >
    
    <div style='border-bottom: 1px solid #ccc;' >
        widget("infuso\\cms\\ui\\widgets\\textarea")
            ->value(trim($task->data("text")))
            ->fieldName("text")
            ->placeholder("Описание задачи")
            ->style("width", "100%")
            ->style("display", "block")
            ->style("border", "none")
            ->style("font-family", "Arial")
            ->style("border-radius", 0)
            ->exec();
    </div>
    
    <div style='padding: 20px;' >
    
        /*<span class='deadline' >
            $id = "x".\util::id();
            <input type='checkbox' id='{$id}' />
            <label for='{$id}' >Дэдлайн</label>
        </span>
    
        widget("infuso\\cms\\ui\\widgets\\datepicker")
            ->value($task->data("timePlanned"))
            ->fieldName("timePlanned")
            ->exec(); */
            
        <table style='width:100%;table-layout: fixed;' >
            <tr>
                <td style='width:100%;' >
                    widget("infuso\\cms\\ui\\widgets\\button")
                        ->text($task->exists() ? "Сохранить" : "Создать")
                        ->attr("type", "submit")
                        ->exec();
                </td>
                <td style='width:80px;' >
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->style("width", 50)
                        ->placeholder("План")
                        ->value($task->timeScheduled())
                        ->fieldName("timeScheduled")
                        ->exec();
                </td>
                <td style='width:40px;' >
                    widget("infuso\\cms\\ui\\widgets\\button")
                        ->air()
                        ->addClass("file")
                        ->icon("attachment")
                        ->attr("type", "button")
                        ->attr("title", "Прикрепить файл")
                        ->exec();
                    <input type='file' style='display:none' name='file' />
                </td>
            </tr>
        </table>
            
    </div>
    
</form>