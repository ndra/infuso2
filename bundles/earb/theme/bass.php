<?

header();

lib::jq();
lib::modJS();
js($this->bundle()->path()."/res/js/earb.js");
js($this->bundle()->path()."/res/js/generator.js");

footer();
