<? 

$user = user::active();

<div class='jmi8th58od' >

    $userpick = user::active()->userpic()->preview(16,16)->crop();
    <a class='profile' href='#conf-profile' >
        <img src='{$userpick}' />
    </a>
    
    <span>{$user->title()}</span>
    
    <span class='logout' >Выйти</span>

</div>