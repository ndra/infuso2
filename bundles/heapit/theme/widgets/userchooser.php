<?
<div class="userChooser-r5rr523ugt"> 
    $path = $this->bundle()->path()."/res/img/widgets/UserChooser/emptyUser.png";
    <img class="currentUser" src='$path'>
    \tmp::exec("user-select", array("fieldName" => $fieldName));
    <input type='hidden' class='user-select-zaqfrsj6nf-{$fieldName}'  name='{$fieldName}'>
</div>