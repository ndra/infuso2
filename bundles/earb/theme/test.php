<?

header();

lib::jq();
lib::modJS();
lib::reset();
js($this->bundle()->path()."/res/js/earb.js");
js($this->bundle()->path()."/res/js/song.js");
js($this->bundle()->path()."/res/js/node.js");

<div class='nRjkjN8GAn' >
    <div class='header' >
        <div class='add' >Добавить</div>
    </div>
    <div class='content' >
        <div class='nodes' ></div>
       // <div class='links' ></div>
    </div>
</div>

footer();