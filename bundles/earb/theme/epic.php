<?

header();

lib::jq();
lib::modJS();
js($this->bundle()->path()."/res/js/earb.js");

footer();