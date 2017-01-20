<? 

$user = app()->user();

<div class='jmi8th58od' >

    $userpick = $user->userpic()->preview(16, 16)->crop();
    $profileURL = action("infuso\\board\\controller\\conf")->url();
    
    <a class='userpick' href='{$profileURL}' >
        <img src='{$userpick}' />
    </a>
    
    <a class='user' href='{$profileURL}' >{$user->title()}</a>
    
    <span class='logout' >Выйти</span>

</div>