<?

// Шаблон для списка опросов в каталоге

<div class='SYun44HISR' >

    <div class='title' >{$poll->data('title')}</div>
    
    if($poll->data("active")) {
        echo "<span style='background:green;padding:4px;color:white;' >Активно</span>";
    }
        
    echo "<small>Создан ".$poll->pdata("created")->txt()."</small>";    
    
    <table class='results' >
    foreach($poll->options()->desc("count") as $option) {
        <tr>
        <td>{$option->title()}</td>
        <td>{$option->count()}</td>
        <td>{$option->percent()}%</td>
        </tr>
    }
    </table>
        
    echo "Всего проголосовало&nbsp;&mdash; ".$poll->answers()->count();

</div>