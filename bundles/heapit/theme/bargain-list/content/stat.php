<? 

$bargains = \Infuso\Heapit\Model\Bargain::all();
$users = \User::all()->withRole("heapit:manager");

<div class='bfmhplhzwd' >

    foreach($users as $user) {

        $html = array();
    
        if($n = $bargains->copy()
            ->eq("userId", $user->id())
            ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_NEW)
            ->sum("amount")) {
            $html[] = "Новые сделки: {$n} р.";
        }
            
        if($n = $bargains->copy()
            ->eq("userId", $user->id())
            ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_INPROCESS)
            ->sum("amount")) {
            $html[] = "Переговоры: {$n} р."; 
        }
        
        if(sizeof($html)) {
                <span class='user' >
                <b>
                    echo $user->title().": ";
                </b>
                echo implode(", ", $html);
            </span>
        }
    
    }
           
</div>