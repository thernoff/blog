<?php

namespace Application;

use Application\Core\Config;

class Db {

    use Singleton;

    protected $dbh;

    protected function __construct() {
        $config = Config::instance()->data;
        $host = $config['db']['host'];
        $dbname = $config['db']['dbname'];
        $dns = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $login = $config['db']['login'];
        $password = $config['db']['password'];

        try {
            $this->dbh = new \PDO($dns, $login, $password);
        } catch (\PDOException $e) {
            throw new \Application\Exceptions\Db($e->getMessage());
        }
    }

    /*
     * Метод execute() используем для выполнения запросов без возвращения данных
     */

    public function execute($sql, $arrParam = []) {
        $sth = $this->dbh->prepare($sql);
        if ($res = $sth->execute($arrParam)) {
            return $res;
        } else {
            throw new \Application\Exceptions\Db('Ошибка в запросе execute: ' . $sql);
        }
    }

    /*
     * Метод query() используем для выполнения запросов с возвращением данных
     */

    public function query($sql, $class, $arrParam = []) {
        $sth = $this->dbh->prepare($sql);

        if ($res = $sth->execute($arrParam)) {//true или false
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class); //Получаем массив, состоящий из объектов класса
        } else {
            throw new \Application\Exceptions\Db('Ошибка в запросе query: ' . $sql);
        }
    }

    /*
     * Метод query() используем для выполнения запросов с возвращением данных
     */

    public function select($sql, $arrParam = []) {
        $sth = $this->dbh->prepare($sql);

        if ($res = $sth->execute($arrParam)) {//true или false
            return $sth->fetchAll(\PDO::FETCH_ASSOC); //Получаем массив, состоящий из объектов класса
        } else {
            throw new \Application\Exceptions\Db('Ошибка в запросе select: ' . $sql);
        }
    }

    /*
     * Метод queryEach() используем для выполнения запросов с возвращением данных в качестве генератора
     */

    public function queryEach($sql, $class, $arrParam = []) {
        $sth = $this->dbh->prepare($sql);
        if ($sth->execute($arrParam)) {//true или false
            $sth->setFetchMode(\PDO::FETCH_CLASS, $class);
            while ($res = $sth->fetch()) {
                yield $res;
            }
        } else {
            throw new \Application\Exceptions\Db('Ошибка в запросе: ' . $sql);
        }
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

}
