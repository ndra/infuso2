<?

header();

lib::jq();
lib::modJS();
lib::reset();


js($this->bundle()->path()."/res/js/earb.js");
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

<div class='nRjkjN8GAn' >
    <div class='header' >
    </div>
    <div class='content' >
        <div class='nodes' ></div>
        <canvas class='links' width='1000' height='500' ></canvas>
    </div>
</div>

footer();