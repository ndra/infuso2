<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Хэндлер карты сайта
 **/
class Sitemap implements Core\Handler {

    /**
     * @handler = reflex/sitemap
     **/
    public static function onSitemap($event) {
        $event->addCollection(Model\Item::all()->active());
        $event->addCollection(Model\Group::all()->active());
    }

}
