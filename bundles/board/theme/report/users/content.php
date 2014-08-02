<? 

header();

lib::reset();

<div style='padding:20px;' >
   
    foreach(user::all()->withRole("boardUser") as $user) {
		exec("user", [
		    "user" => $user,
		]);
    }

</div>

footer();