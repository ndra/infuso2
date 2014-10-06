<?

$w = helper("<div>");
$w->addClass("u8fWiE6rDe user-bar");
$w->begin();

    $url = action("infuso\\heapit\\controller\\bargain");

    // Сделки сегодня
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("userId", $user->id())
        ->eq("status", array(0, 200, 500))
        ->eq("date(callTime)", \util::now()->date());
        
    if($n = $bargains->count()) {
        <a href='{$url}' >Сделки сегодня: {$n}</a>
        $green = true;
    }
    
    // Сделки пропущены
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("userId", $user->id())
        ->eq("status", array(0, 200, 500))
        ->lt("date(callTime)", \util::now()->date());
        
    if($n = $bargains->count()) {
        <a href='{$url}' >Сделки пропущены: {$n}</a>
        $red = true;
    }

    // Плетежи сегодня
    
    $url = action("infuso\\heapit\\controller\\payment");
    
    $statusList = array(
        \Infuso\Heapit\Model\Payment::STATUS_PLAN,
        \Infuso\Heapit\Model\Payment::STATUS_PUSHED,
    );
    
    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("userId", $user->id())
        ->eq("status", $statusList)
        ->eq("date", \util::now()->date());
        
    if($n = $payments->count()) {
        <a href='{$url}' >Платежи сегодня: {$n}</a>
        $green = true;
    }
    
    // Пропущенные платежи
    
    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("userId", $user->id())
        ->eq("status", $statusList)
        ->lt("date", \util::now()->date());
        
    if($n = $payments->count()) {
        <a href='{$url}' >Платежи пропущены: {$n}</a>
        $red = true;
    }
    
    
if($red) {
    $w->style("background", "red");
}

if(!$red && !$green) {
    //$w->style("display", "none");
}

$w->end();