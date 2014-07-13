<?

header();

lib::jq();
lib::modjs();

<div class='ogtvEmHlon' >
    for($i=0;$i<10;$i++) {
        <div class='item' draggable="true" >
            echo $i;
            <div class='prev' ></div>
            <div class='next' ></div>
            <div class='here' ></div>
        </div>
    }
</div>

footer();