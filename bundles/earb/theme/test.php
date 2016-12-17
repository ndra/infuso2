<?

header();

lib::jq();
lib::modJS();
lib::reset();


js($this->bundle()->path()."/res/js/earb.js");
js($this->bundle()->path()."/res/js/base.js");
js($this->bundle()->path()."/res/js/song.js");
js($this->bundle()->path()."/res/js/node.js");
js($this->bundle()->path()."/res/js/node.view.js");
js($this->bundle()->path()."/res/js/node.generator.js");
js($this->bundle()->path()."/res/js/node.generator.view.js");
js($this->bundle()->path()."/res/js/node.gain.js");
js($this->bundle()->path()."/res/js/node.gain.view.js");

/*js($this->bundle()->path()."/res/js/nodeView.js");
js($this->bundle()->path()."/res/js/node.js");

js($this->bundle()->path()."/res/js/node.generator.js");
js($this->bundle()->path()."/res/js/node.generator.view.js");
js($this->bundle()->path()."/res/js/node.noise.js");
js($this->bundle()->path()."/res/js/node.noise.view.js");
js($this->bundle()->path()."/res/js/node.gain.js");
js($this->bundle()->path()."/res/js/node.gain.generator.js"); */

<div class='nRjkjN8GAn' >
    <div class='header' >
        //<div class='add' >Добавить</div>
    </div>
    <div class='content' >
        <div class='nodes' ></div>
       // <div class='links' ></div>
    </div>
</div>

footer();