<? 

<div class='ro33jkjt9t' >

    $orgs = \Infuso\Heapit\Org::all()->asc('id');
    foreach($orgs as $org) {
        <div>
            echo $org->title();
        </div>
    }

</div>