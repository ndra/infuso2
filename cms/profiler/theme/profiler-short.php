<?

<div class='c8vWaICF5n' >

    echo "generated: ".round($data["variables"]["time"], 2)." sec.";
    <br/>
    echo "Page size : ".\util::bytesToSize1000($data["variables"]["contentSize"]);
    <br/>
    echo "Memory: ".\util::bytesToSize1000($data["variables"]["memory-peak"])." / ".$data["variables"]["memory-limit"];

</div>

