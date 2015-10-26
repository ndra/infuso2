<?

<table class='GFGSWihfWS' >
    foreach(service("log")->all()->eq("type", "1c/exchange")->limit(100)->desc("datetime") as $item) {
        <tr>
            <td class='time' >{$item->pdata(datetime)->left()}</td>
            <td>{$item->message()}</td>
        </tr>
    }
</table>