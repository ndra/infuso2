<?

echo "<div>";

echo "<h2>{$poll->data('title')}</h2>";
echo "Спасибо за голосование. Вот как распределились результаты:";
echo "<table>";
foreach($poll->options()->desc("count") as $option) {
    echo "<tr>";
    echo "<td>{$option->title()}</td>";
    echo "<td>{$option->count()}</td>";
    echo "<td>{$option->percent()}%</td>";
    echo "</tr>";
}
echo "</table>";
echo "Всего проголосовало&nbsp;&mdash; ".$poll->answers()->count();

echo "</div>";