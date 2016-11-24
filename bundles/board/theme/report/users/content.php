<? 

header();

lib::reset();

<div class='jUJZyDrMqf' >

    foreach(user::all()->withRole("board/worker") as $user) {
		exec("user", [
		    "user" => $user,
		]);
    }
   
</div>

footer();