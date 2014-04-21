<?

$anonymousUserpic = $this->bundle()->path()."/res/img/widgets/UserChooser/anonymous.png";
$anonymousName = "Никто";

<div class="userChooser-r5rr523ugt">

    $user = \user::get($userId);
    if($user->exists()) {
        $userpic = $user->userpic()->preview(100,100)->crop();
        $username = $user->title();
    } else {
        $userpic = $anonymousUserpic;    
        $username = $anonymousName;
    } 
    
    // Вывод выбранного пользователя
    <div class="currentUser" >
        <img src='{$userpic}' class='userpic' />
        <div class="name" >{$username}</div>
    </div>    
    
    exec("user-select", array(
        "anonymousUserpic" => $anonymousUserpic,
        "anonymousName" => $anonymousName,
    ));
    <input type='hidden' class='user-select-hiddenField' name='{$name}' value='{$userId}' > 
    
</div>