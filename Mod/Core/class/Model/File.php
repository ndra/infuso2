<?

namespace Infuso\Core\Model;
use infuso\util\util;
use Infuso\Core;

class File extends Field {

    public function typeID() {
        return "knh9-0kgy-csg9-1nv8-7go9";
    }

    public function typeName() {
        return "Файл";
    }

    public function mysqlType() {
        return "varchar(255)";
    }

    public function mysqlIndexType() {
        return "index";
    }

    public function pvalue() {
        return Core\File::get($this->value());
    }

}
