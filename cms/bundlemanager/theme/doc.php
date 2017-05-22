<?

admin::header();

<div style='padding: 40px;' >
    <h1>Все модули</h1>
    <br>
    foreach(service("bundle")->all() as $bundle) {
        <div>
        $url = action("infuso\\cms\\bundlemanager\\controller\\doc", "bundle")."?bundle=".urlencode($bundle->path());
        <a href='{$url}' >{$bundle->path()}</a>
        </div>
    }
</div>

admin::footer();

