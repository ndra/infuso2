<?

header();

lib::jq();
lib::modJS();
js($this->bundle()->path()."/res/js/earb.js");
js($this->bundle()->path()."/res/js/note.js");
js($this->bundle()->path()."/res/js/voice.js");
js($this->bundle()->path()."/res/js/channel.js");
js($this->bundle()->path()."/res/js/channelController.js");
js($this->bundle()->path()."/res/js/pattern.js");

footer();