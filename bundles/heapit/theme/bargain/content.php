<? 

<form class="bairgain-item-s0jioq8htr" data:bargainid='{$bargain->id()}' >
    if($bargain->exists()) {
        exec("contact");
    }
    exec("/heapit/bargain-form");
</form>