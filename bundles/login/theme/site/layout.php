<?

exec("shared");

header();
 
lib::modJS();
lib::reset();

js($this->bundle()->path()."/res/js/jquery.formattable.js");

head("<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,700,500,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>");
js("https://www.gstatic.com/charts/loader.js");

exec("header");

<div class='b-center' >
    region("center");
</div>

<div class='footer' ></div>

if(app()->url()->domain() != "ebike.mysite.ru") {
    exec("counters");
}

footer();