<?php

namespace Application;

use Application\Db;

abstract class Model {

    const TABLE = '';

    //Принимаем соглашение: в каждой таблицы БД есть поле id с первичным ключом
    public $id;

    public static function findAll() {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE, static::class);

        return $res;
    }

    public static function findAllIsActive() {
        if (property_exists(static::class, "is_active")) {
            $db = Db::instance();
            $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE is_active = :is_active', static::class, [':is_active' => 1]);
        } else {
            $res = [];
        }

        return $res;
    }

    public static function findAllArray() {
        $db = Db::instance();
        $res = $db->select('SELECT * FROM ' . static::TABLE);
        return $res;
    }

    public static function findAllByGenerate() {
        $db = Db::instance();
        $res = $db->queryEach('SELECT * FROM ' . static::TABLE, static::class);
        return $res;
    }

    public static function findById($id) {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE id = :id', static::class, [':id' => $id]);

        if ($res[0]) {
            return $res[0];
        } else {
            return false;
        }
    }

    public static function findByWhere($where, $arrParams) {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . " " . $where, static::class, $arrParams);
        return $res;
    }

    public static function search($field, $search) {
        $db = Db::instance();
        $search = "%$search%";
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE ' . $field . ' LIKE :search', static::class, [':search' => $search]);        
        return $res;
    }

    public function isNew() {
        return empty($this->id);
    }

    public function insert() {
        if (!$this->isNew()) {
            //Если объект не является только что созданным, то выходим из метода insert()
            return;
        }

        $columns = [];
        $values = [];
        foreach ($this as $key => $value) {
            if ('id' == $key) {
                continue;
            }

            $columns[] = $key;
            $values[':' . $key] = $value;
            //$values[':'.$key] = htmlspecialchars($value);
        }

        $sql = 'INSERT INTO ' . static::TABLE . ' (' . implode(',', $columns) . ') VALUE (' . implode(',', array_keys($values)) . ')';
        $db = Db::instance();
        $db->execute($sql, $values);
        $this->id = $db->lastInsertId();
    }

    public function update() {
        if ($this->isNew()) {
            return; //Если объект не является только что созданным, то выходим из метода update()
        }

        $columns = []; //В данный массив записываем наименования полей таблицы или свойства объекта
        $values = []; //В данный массив будем записывать значения полей таблицы или значения свойств объекта
        foreach ($this as $key => $value) {
            if ('id' == $key) {
                continue;
            }
            $columns[] = $key . '=:' . $key;
            //$values[':'.$key] = htmlspecialchars($value);
            $values[':' . $key] = $value;
        }
        $sql = 'UPDATE ' . static::TABLE . ' SET ' . implode(',', $columns) . ' WHERE id = :id';
        $values[':id'] = $this->id;
        $db = Db::instance();
        $db->execute($sql, $values);
    }

    public function save() {
        if (!$this->isNew()) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function delete() {
        if ($this->isNew()) {
            return; //Если объект не является только что созданным, то выходим из метода insert()
        }

        $sql = 'DELETE FROM ' . static::TABLE . ' WHERE id = :id';
        $values[':id'] = $this->id;
        $db = Db::instance();
        $db->execute($sql, $values);
    }

    public function fillFromArray($arr) {
        foreach ($arr as $key => $value) {

            if (property_exists(static::class, $key)) {
                //$this->$key = htmlspecialchars($value);
                $this->$key = $value;
            }
        }
    }

    public function validate() {
        $arrFields = get_object_vars($this);

        foreach ($arrFields as $field) {
            if (empty($field)) {
                return false;
            }
        }
    }

    /*
     * Данный метод позволяет получить дерево (массив) с дочерними элементами, 
     * при условии если объект (и соответствующая таблица) имеют поля id и id_parent
     * Если параметр $table не указан, то по умолчанию выборка делается из таблицы соответстующей данному объекту.
     */

    public function getTree($table = '', $level = 0) {
        if (!$table) {
            $table = static::TABLE;
        }

        $arrVars = get_object_vars($this);

        if (array_key_exists('id', $arrVars) && array_key_exists('id_parent', $arrVars)) {
            return $this->makeTree($table, $level);
        } else {
            throw new \Exception("Отсутствуют ключи id и id_parent");
        }
        return [];
    }

    public static function makeTree($table, $level = 0) {
        $map = array();
        $db = Db::instance();
        $objects = $db->select("SELECT * FROM " . $table . " WHERE id_parent = :id_parent", [":id_parent" => $level]);
        if (!empty($objects)) {
            foreach ($objects as $object) {
                $object['children'] = static::makeTree($table, $object['id']);
                $map[] = $object;
            }
        }
        return $map;
    }

}
