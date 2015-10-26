<?

namespace Infuso\ActiveRecord\Migration;

use Infuso\core\mod;
use Infuso\core\file;

/**
 * Класс миграции mysql
 **/
class Table {

    /**
     * сюда будут складываться кусочки запросов по изменению таблицы
     **/
    private $q = array();

    private $model = null;

    private $messages = array();

    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * Возвращает имя таблицы
     **/
    public function tableName() {
        return $this->model["name"];
    }

    /**
     * Возвращает имя таблицы с префиксом
     * @todo использовать реальный префикс
     **/
    public function prefixedTableName() {
        return "infuso_".$this->model["name"];
    }

    /**
     * Возвращает массив полей таблицы
     * Элемнты массива - объекты
     **/
    public function fields() {
        $ret = array();
        foreach($this->model["fields"] as $field) {
            $ret[] = \Infuso\Core\Model\Field::get($field);
        }
        return $ret;
    }

    public function fieldExists($name) {
        foreach($this->model["fields"] as $field) {
            $field = \Infuso\Core\Model\Field::get($field);
            if($field->name() == $name) {
                return true;
            }
        }
        return $false;
    }

    /**
     * Возвращает массив индексов таблицы
     * Элемнты массива - объекты
     **/
    public function indexes() {
        $ret = array();
        foreach($this->fields() as $field) {
            if($field->param("index") || 1) {
                $index = new Index($field->dbIndex());
                $ret[] = $index;
            }
        }
        return $ret;
    }

    private function msg($msg) {
        $this->messages[] = $msg;
    }

    public function getMessages() {
        return $this->messages;
    }

    /**
     * Миграция таблицы до актуального состояния
     **/
    public function migrateUp() {

        if(!$this->tableName()) {
            throw new \Exception("Migration: table name missing");
        }

        $this->createTable();

        $this->updateEngine();

        // Проверяем таблицу на наличие дублирующихся полей
        $names = array();
        foreach($this->fields() as $field) {
            if(in_array($field->name(),$names)) {
                throw new \Exception("Duplicate field name <b>{$field->name()}</b> in table <b>{$this->table()->name()}</b>",1);
            }
            $names[] = $field->name();
        }

        // Добавляем / восстанавливаем нужные поля
        foreach($this->fields() as $field) {
            $this->updateField($field);
        }


        // Удаляем лишние поля
        foreach($this->realFields() as $field) {
            if(!$this->fieldExists($field)) {
                app()->msg("Field ".$this->tableName().".".$field." not exists in model.", 1);
                $this->deleteField($field);
            }
        }

        $this->updateIndex();

        if(sizeof($this->q)) {
            $q = implode(", ",$this->q);
            $q = "alter table `{$this->prefixedTableName()}` $q"; 
            return service("db")->query($q)->exec();
        }

    }

    /**
     * Меняем движок таблицы
     **/         
    public function updateEngine() {
        $name = service("db")->quote($this->prefixedTableName());
        $query = "SHOW TABLE STATUS where `Name` = {$name} ";          
        $status = service("db")->query($query)->exec()->fetch();
        
        $oldEngine = $status["Engine"];
        $newEngine = "MyISAM";
        if($oldEngine != $newEngine) {
            $this->msg($query);
            $this->q[] = "ENGINE = {$newEngine}";
            $this->msg("Changing engine from {$engine} to {$newEngine}");
        }
    }

    /*public function updateRowFormat() {
        reflex_mysql::query("SHOW TABLE STATUS like '{$this->table()->prefixedName()}' ");
        $status = reflex_mysql::get_row();
        $format = $status["Row_format"];
        if($format!="Fixed") {
            $this->q[] = "ROW_FORMAT = FIXED";
            app()->msg("change row format");
        }
    }*/

    /**
     * Возвращает таблицу (она передавалась в конструктор)
     **/
    public function table() {
        return $this->table;
    }

    public function needType($field) {

        $type = $field->mysqlType()." ";

        if(preg_match("/(varchar)|(longtext)/i",$type)) {
            $type.= "COLLATE utf8_general_ci ";
        }

        if(!$field->mysqlNull()) {
            $type.="NOT NULL ";
        }

        if($field->mysqlAutoIncrement()) {
            $type.= "auto_increment ";
        }

        return strtolower($type);

    }

    public function existsType($field) {

        $descr = $this->describeField($field);
        $ret = $descr["Type"]." ";

        if($c = $descr["Collation"]) {
            $ret.= "collate ".$c." ";
        }

        if($descr["Null"]=="NO") {
            $ret.= "NOT NULL ";
        }

        if($descr["Extra"]=="auto_increment") {
            $ret.= "auto_increment ";
        }

        return strtolower($ret);
    }

    public function updateField($field) {

        $a = $this->needType($field);
        $b = $this->existsType($field);
        $descr = $this->describeField($field);

        if(!$descr) {
            $this->createField($field,$a);
        } else {

            $alter = trim($a)!=trim($b);
            $type = $a;

            if($alter) {
                $this->q[] = "MODIFY `{$field->name()}` $type ";
            }
        }
    }

    /**
     * Создает таблицу, если ее еще нет
     * Вызывается в начале миграции
     **/
    public function createTable() {
        $table = $this->prefixedTableName();
        $query = "create table if not exists `$table` (`id` bigint(20) primary key) ";
        service("db")->query($query)->exec();
    }

    /**
     * Возвращает описание поля
     **/
    public function describeField($field) {
        $query = "show full columns from `{$this->prefixedTableName()}` ";
        $ret = service("db")->query($query)->exec()->fetchAll();
        foreach($ret as $row) {
            if($row["Field"] == $field->name()) {
                return $row;
            }
        }
    }

    /**
     * Возвращает список полей в реальной таблице
     **/
    public function realFields() {
        $query = "show full columns from `{$this->prefixedTableName()}` ";
        return service("db")->query($query)->exec()->fetchCol("Field");
    }

    /**
     * Добавляет поле в таблиу
     **/
    public function createField($field,$descr) {
        $this->q[] = "add `{$field->name()}` $descr";
        $this->msg("Add field ".$field->name());
    }

    /**
     * Удаляет поле из таблицы
     **/
    public function deleteField($field) {
        $this->q[] = "drop `{$field}`";
        $this->msg("Delete field ".$field);
    }

    /**
     * Обновляет индекс до требуемого состояния
     **/
    public function updateIndex() {

        $q = array();

        // Индексы, которые должны быть
        $a = array();
        foreach($this->indexes() as $index) {
            $fields = \infuso\util\util::splitAndTrim($index->fields(),",");
            sort($fields);
            $a[$index->name()]["fields"] = $fields;
            $a[$index->name()]["type"] = $index->type();
        }

        // Индексы, которые реально есть
        $b = array();
        $query = "show index from `{$this->prefixedTableName()}` ";
        $items = service("db")->query($query)->exec()->fetchAll();

        foreach($items as $index) {
            $name = $index["Key_name"];
            $indexDescr = $index["Column_name"];
            if($n=$index["Sub_part"]) {
                $indexDescr.= "(".$n.")";
            }
            $b[$name]["fields"][] = $indexDescr;

            if($name == "PRIMARY") {
                   $b[$name]["type"] = "primary";
            } else {
                $b[$name]["type"] = $index["Index_type"] == "BTREE" ? "index" : "fulltext";
            }
        }

        // Сортируем поля
        foreach($b as $key => $val) {
            $fields = $val["fields"];
            sort($fields);
            $b[$key]["fields"] = $fields;
        }

        // Добавляем/изменяем индексы
        foreach($a as $name => $index) {

            $hash1 = serialize($index);
            $hash2 = serialize($b[$name]);

            $fields = array();
            foreach($index["fields"] as $field) {
                preg_match("/^([^()]*)(\(\d+\))?$/i",$field,$matches);
                $fields[] = "`".$matches[1]."`".($matches[2] ? " {$matches[2]}" : "");
            }

            $fields = implode(",",$fields);

            if($hash1!=$hash2) {

                if(array_key_exists($name,$b)) {
                    $this->q[] = "drop index `$name`";
                }

                $type = $index["type"];

                if($name=="PRIMARY") {
                    $this->q[] = "add primary key($fields)";
                } else {
                    $this->q[] = "add $type `$name` ($fields) ";
                }

                $this->msg("Update index ".$name);

            }

        }

        // Убираем ненужные индексы
        foreach($b as $name => $dummy) {
            if(!array_key_exists($name,$a)) {
                $this->q[] = "drop index `$name`";
            }
        }

    }

    // Удаляет таблицу
    /*public static function deleteTable()    {
        $table = reflex_mysql::getPrefixedTableName($table);
        reflex_mysql::query("drop table `$table` ");
    } */

}
