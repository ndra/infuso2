<?

admin::header();

<div class='M1TOmdK6Sg' >

    $sites = array(
        "cosmetic-ug.ru",
        "miland.ru.com",
        "knigi.prof-press.ru",
        "kanz.prof-press.ru",
        "board.ndra.ru",
        "heapit.com",
        "home.heapit.com",
        "rodnieprostori.ru",
    );
    
    foreach($sites as $site) {
        $url = \Infuso\Core\File::HTTP("http://$site/heartbeat-telemetry");
        $data = $url->data();
        $data = json_decode($data, 1);
        
        echo $site.": ";
        if($data) {
            echo $data["health"];
        } else {
            echo "telemetry not found";
        }
        echo "<br/>";
    }

</div>

admin::footer();