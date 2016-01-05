<?

lib::jq();
lib::modJS();

foreach(\Infuso\Poll\Model\Poll::all()->eq("active", true) as $poll) {

    <div class='yndsnQpjcv' >
        exec("ajax", array (
            "poll" => $poll,
        ));
    </div>
    
}