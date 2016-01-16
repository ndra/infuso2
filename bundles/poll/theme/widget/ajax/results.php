<?

<div>

<h2>{$poll->data('title')}</h2>
echo "Спасибо за голосование! Вот как распределились результаты:";
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