<?

namespace Infuso\Cms\Reflex;

interface AutoRoute {

    /**
     * Должна сгенерировать и вернуть урл
     * Если вернет null, то урл объекта будет удален
     **/
    public function generateURL();

}
