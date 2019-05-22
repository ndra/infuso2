<?

//\Infuso\Update\Github::extract("/xxx/1.zip", "/xxx/here", "/bundles/ndraplugins/");

header();

\Infuso\Update\Updater::update("bundles/ndraplugins");
//\Infuso\Core\File::get("var/__tmp/qk1hjmubnmehtk5h789i")->rename("bundles/ndraplugins3");

footer();