<?php

namespace Application\Models;

use Application\Model;
use Application\Db;

class Session extends Model {

    use \Application\Singleton;

    const TABLE = 'blog_sessions';

    public $id_user;
    public $sid;
    public $time_start;
    public $time_last;

    private function __construct() {
        session_start();
    }

    public static function setSessionData($key, $data) {
        session_start();
        $_SESSION[$key] = $data;
    }

    public static function getSessionData($key) {
        session_start();
        return $_SESSION[$key];
    }

    public static function unsetSession($key) {
        unset($_SESSION[$key]);
    }

    public static function findBySID($sid) {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE sid = :sid', static::class, [':sid' => $sid]);
        return $res;
    }

    /*
     * Очистка неиспользуемых сессий
     */

    public static function clearSession() {
        $min = date('Y-m-d H:i:s', time() - 60 * 40);
        $sql = "DELETE FROM " . self::TABLE . " WHERE time_last < :min";
        $db = Db::instance();
        $db->execute($sql, [":min" => $min]);
    }

    /*
     * Удаление текущей сессии из базы данных
     */

    public static function deleteSessionFromDataBase() {
        //Ищем SID
        $sid = Session::getSessionData('sid');

        //Если нашли, попробуем обновить time_last в базе данных.
        if ($sid !== null) {
            $sql = 'DELETE FROM ' . static::TABLE . ' WHERE sid = :sid';
            $db = Db::instance();
            $db->execute($sql, [':sid' => $sid]);
        }
    }

}
