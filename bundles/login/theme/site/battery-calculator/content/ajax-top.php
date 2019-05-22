<?

if($battery->cell()->exists()) {
    exec("battery-info");    
} else {
    exec("example");
}