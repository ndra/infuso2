<?

header();

//<canvas width=1200 height=200 style='border: 1px solid red;' id='canvas' ></canvas>

lib::jq();
lib::modJS();
js($this->bundle()->path()."/res/js/earb.js");

footer();