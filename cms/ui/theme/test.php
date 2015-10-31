<?

header();

widget("infuso\\cms\\ui\\widgets\\datetime")
    ->value(\Infuso\Util\Util::now())
    ->exec();

footer();