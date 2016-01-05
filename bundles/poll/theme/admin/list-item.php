<?

// Шаблон для списка опросов в каталоге

<div class='SYun44HISR list-item' data:id='{$poll->id()}' >

    <table class='header' >
        <tr>
            <td>
                <a class='title' href='{$editor->url()}' >{$poll->data('title')}</a>
            </td>
            <td>
                if($poll->data("active")) {
                    echo "<span class='active' >Активно</span>";
                }
            </td>
            <td class='date' >
                <span>{$poll->pdata("created")->txt()}</span>
            </td>
        </tr>
    </table>
    
    <table class='results' >
        foreach($poll->options()->desc("count") as $option) {
            <tr>
            <td>{$option->title()}</td>
            <td>{$option->count()}</td>
            <td>{$option->percent()}%</td>
            </tr>
        }
        <tr>
            <td>Всего проголосовало</td>
            <td>{$poll->answers()->count()}</td>
            <td></td>
        </tr>
    </table>

</div>