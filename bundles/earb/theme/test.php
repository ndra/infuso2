<?

header();

lib::jq();
lib::modJS();
lib::reset();


js($this->bundle()->path()."/res/js/earb.js");
js($this->bundle()->path()."/res/js/earb.dragndrop.js");
js($this->bundle()->path()."/res/js/base.js");
js($this->bundle()->path()."/res/js/song.js");
js($this->bundle()->path()."/res/js/link.js");
js($this->bundle()->path()."/res/js/node.js");
js($this->bundle()->path()."/res/js/node.view.js");
js($this->bundle()->path()."/res/js/node.generator.js");
js($this->bundle()->path()."/res/js/node.generator.view.js");
js($this->bundle()->path()."/res/js/node.gain.js");
js($this->bundle()->path()."/res/js/node.gain.view.js");
js($this->bundle()->path()."/res/js/node.out.js");
js($this->bundle()->path()."/res/js/node.out.view.js");
js($this->bundle()->path()."/res/js/node.pedal.js");
js($this->bundle()->path()."/res/js/node.pedal.view.js");
js($this->bundle()->path()."/res/js/node.delay.js");
js($this->bundle()->path()."/res/js/node.delay.view.js");
js($this->bundle()->path()."/res/js/node.pattern.js");
js($this->bundle()->path()."/res/js/node.pattern.view.js");
js($this->bundle()->path()."/res/js/node.synthesizer.js");
js($this->bundle()->path()."/res/js/node.synthesizer.view.js");


<div class='nRjkjN8GAn' >
    <div class='header' >
    </div>
    <div class='content' >
        <div class='nodes' ></div>
        <svg class='links' width='1000' height='500' ></svg>
    </div>
</div>

footer();