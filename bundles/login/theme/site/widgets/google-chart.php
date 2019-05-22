<?

js("https://www.gstatic.com/charts/loader.js");

$data = array(
    "values" => $values,
    "options" => $options,
);

<div class='zRfYi7ftb9' >
    <input value='{e(json_encode($data))}' type='hidden' />
    <div class='chart' ></div>
</div>