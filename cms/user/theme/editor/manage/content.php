<? 

exec("/reflex/shared/editor-head");

$user = $editor->item();

<div class='eacthazen4' >

    exec("change-email", array(
        "user" => $user,
    ));
    
    exec("change-password", array(
        "user" => $user,
    ));
    
</div>