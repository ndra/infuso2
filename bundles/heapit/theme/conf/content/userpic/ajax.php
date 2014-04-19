<? 

$user = \User::active();
$preview = $user->userpic()->preview(200,200)->crop();

<div class='bfk7mngrw4' >
    <img src='{$preview}' />
</div>