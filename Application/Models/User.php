<?php

namespace Application\Models;

use Application\Model;
use Application\Db;
use Application\Models\Session;

class User
    extends Model
{
    use \Application\Singleton;
    
    const TABLE = 'blog_users';
    
    public $login;
    public $password;
    public $role;
    public $name;
    
    private $id_user;

    public function login($login, $password, $remember = true)
    {
        //Получаем пользователя из базы данных
        $user = $this->getByLogin($login);
        
        if ($user == null){
            return false;
        }
        
        $id_user = $user->id;
        
        //Проверка пароля
        if ($user->password !== md5($password)){
            return false;
        }
        
        //Запоминаем имя и md5(пароль)
        if ($remember){
            $expire = time() +3600 * 24 * 100;
            setcookie('login', $login, $expire);
            setcookie('password', md5($password), $expire);
        }
        
        //Открываем сессию
        $this->sid = $this->openSession($id_user);
        
        return true;
    }
    
    public function logout()
	{
            setcookie('login', '', time() - 1);
            setcookie('password', '', time() - 1);
            unset($_COOKIE['login']);
            unset($_COOKIE['password']);
            Session::deleteSessionFromDataBase();
            Session::unsetSession('sid');
            header("Location: /index.php?controller=main&action=autorize");
            //$this->sid = null;
            //$this->uid = null;
	}
    
    /*
     * Получение пользователя по логину
     */
    public function getByLogin($login)
    {
        $db = Db::instance();
        $sql = "SELECT * FROM " . self::TABLE . " WHERE login = :login";
        //echo $sql."<br>";
        //echo $login."<br>";
        $res = $db->query($sql, self::class, [':login' => $login]);
        //var_dump($res);
        //В случае успеха возвращаем объект класса User
	return ($res) ? $res[0] : null;
    }    
    
    /*
     * Получение текущего пользователя
     */
    public function getUser($id_user = null)
    {
        Session::clearSession();
        //Если id_user не указан, берем его из текущей сессии
        if ($id_user == null){
            $id_user = $this->getIdUser();
            //echo 'User::getUser: id_user = '.$id_user."<br>";
        }
        
        if ($id_user == null){
            //echo 'Пользователь отсутствует '."<br>";
            return $this;
        }
        
        //Возвращаем пользователя по id_user
        return parent::findById($id_user);
    }
    
    /*
     * Получение id текущего пользователя
     * Резултат - uid
     */
    
    public function getIdUser()
    {
        $sid = $this->getSID();
        //echo 'Получаем из getIdUser в самом начале $sid = $this->getSID(), sid = ' . $sid."<br><br>";
        
        if ($sid == null){
            return null;
        }
        
        $sql = "SELECT * FROM blog_sessions WHERE sid = :sid";
        //$res = $db->query($sql, self::class, [':sid' => $sid]);
        $res = Session::findBySID($sid);
        //Если сессию не нашли, значит пользователь не авторизован
        if (count($res) == 0){  
            //echo 'count($res) = ' . 0 . "<br>";
            return null;
        }
        //echo "<hr>";
        //var_dump($res);
        //echo "<hr>";
        //Если сессия найдена, запоминаем ее.
        $this->id_user = $res[0]->id_user;        
        return $this->id_user;
    }
    
    /*
     * Получение id сессии
     */
    public function getSID()
    {
        //Ищем SID
        $sid = Session::getSessionData('sid');
        //Если нашли, попробуем обновить time_last в базе данных.
        if ($sid !==null){
            if ($session = Session::findById($sid)){
                $session->time_last = date('Y-m-d H:i:s');
                $session->save();
            }
            
        }
        
        //Если sid отсутствует, проверяем куки и переавторизовываем пользователя заново
        if ($sid == null && isset($_COOKIE['login'])){
            $user = $this->getByLogin($_COOKIE['login']);
            //var_dump($user);
            if ($user !== null && $user->password == $_COOKIE['password']){
                $sid = $this->openSession($user->id);
            }
        }
        //echo 'SID : '.$sid."<br>";
        //Возвращаем sid
        //echo 'SID (getSID): '.$sid."<br>";
        return $sid;
    }
   
    /*
     * Открытие новой сессии
     * Результат - sid
     */
    private function openSession($id_user)
    {
        //Генерируем sid
        $sid = $this->generateStr();
        
        //Вставляем sid в базу данных
        $now = date('Y-m-d H:i:s');
        
        $session = Session::instance();
        $session->id_user = $id_user;
        $session->sid = $sid;
        $session->time_start = $now;
        $session->time_last = $now;
        $session->save();
        
        //Регистрируем сессию в PHP сессии
        Session::setSessionData('sid', $sid);
        
        return $sid;
    }


    /*
     * Генерация случайной последовательности
     * $length - ее длина
     * результат - случайная строка
     */
    private function generateStr($length = 5)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        
        while (strlen($code) < $length)
        {
            $code .= $chars[mt_rand(0, $clen)];
        }
        $code .= time();
        return $code;
    }
    
    public function isAutorize()
    {
        if ($this->id){
            return true;
        }
        
        return false;
    }

    private function hash($str)
    {
        return md5(md5($str));
    }
}
