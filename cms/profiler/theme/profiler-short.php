<?

<div class='c8vWaICF5n' >

    echo "generated: ".round(microtime(1)-$GLOBALS["infusoStarted"],2)." sec.";
    <br/>
    echo "Page size : ".\util::bytesToSize1000($data["variables"]["contentSize"]);
    <br/>
    echo "Memory: ".\util::bytesToSize1000(memory_get_peak_usage())." / ".ini_get("memory_limit");

</div>

