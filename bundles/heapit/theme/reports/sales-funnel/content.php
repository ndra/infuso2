<? 

<div class='djrh5zbe5a' >
    
    $bargains = \Infuso\Heapit\Model\Bargain::all();
    exec("funnel", array(
        "bargains" => $bargains,
        "title" => "Все менеджеры",
    ));
    
    $users = \User::all()->withRole("heapit:manager");
    foreach($users as $user) {
        $bargains = \Infuso\Heapit\Model\Bargain::all()
            ->eq("userId",$user->id());
        exec("funnel", array(
            "bargains" => $bargains,
            "title" => $user->title(),
        ));
    }
    
</div>