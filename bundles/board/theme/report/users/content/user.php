<?

ob_start();
widget("infuso\\board\\widget\\timeline")
    ->param("from", \util::now()->date()->shiftMonth(-1))
    ->param("to", \util::now()->date())
    ->userId($user->id())
    ->exec();
$timeline = trim(ob_get_clean());

// ЧОрная магия
// Не выводим данные пользователей которые бездельничали
// Так как даже если виджет timeline вернет пустую строку, все равно в html 
// попадут комментарии начала и конца виджета
// Вот так криво мы фильтруем этот случай
if(strlen($timeline) < 100) {
    return;
}

<div class='dg13nhbck2' >

    <h2>{$user->title()}</h2>
    echo $timeline;

</div>