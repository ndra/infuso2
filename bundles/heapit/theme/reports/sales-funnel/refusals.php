<? 

<div class='djrh5zbe5a' >
    
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->gt("callTime", \util::now()->shiftMonth(-4));
    exec("manager", array(
        "bargains" => $bargains->copy(),
        "title" => "Все менеджеры",
    ));
    
    $users = \User::all()->withRole("heapit:manager");
    foreach($users as $user) {
        exec("manager", array(
            "bargains" => $bargains->copy()->eq("userId",$user->id()),
            "title" => $user->title(),
        ));
    }
    
</div>