<?php
namespace Application;

use Application\Core\Config;

class Db
{
	use Singleton;
	
	protected $dbh;
	
	protected  function __construct()
	{
            $config = Config::instance()->data;
            $host = $config['db']['host'];
            $dbname = $config['db']['dbname'];
            $dns = 'mysql:host='.$host.';dbname='.$dbname;
            $login = $config['db']['login'];
            $password = $config['db']['password'];
            try {
                    $this->dbh = new \PDO($dns,$login,$password);
            }catch(\PDOException $e){
                echo "Исключение";die();
                throw new \Application\Exceptions\Db('Возникла проблема при подключении к базе данных.'); 
            }
	}
	/*
	 * Метод execute() используем для выполнения запросов без возвращения данных
	 */
	public function execute($sql, $arrParam = [])
	{
            //var_dump($arrParam);
            $sth = $this->dbh->prepare($sql);		
            if ($res = $sth->execute($arrParam)){				
                    return $res;
            }else{				
                    throw new \Application\Exceptions\Db('Ошибка в запросе execute: ' . $sql);
            }
		
	}
	/*
	 * Метод query() используем для выполнения запросов с возвращением данных
	 */
	public function query($sql, $class, $arrParam = [])
	{
            //echo "<pre>";
            //echo '$sql = ' . $sql . "<br>";
            //echo "<br>";
            //var_dump($arrParam);
            //var_dump($class);
            //echo "</pre>";
            //echo "<br>";
            $sth = $this->dbh->prepare($sql);
            //var_dump($sth);
            
            if ($res = $sth->execute($arrParam)){//true или false
                    return $sth->fetchAll(\PDO::FETCH_CLASS, $class);//Получаем массив, состоящий из объектов класса
            }else{
                    throw new \Application\Exceptions\Db('Ошибка в запросе query: ' . $sql);
                    //return [];
            }
	}
        
        /*
	 * Метод query() используем для выполнения запросов с возвращением данных
	 */
	public function select($sql, $arrParam = [])
	{
            
            //echo '$sql = ' . $sql . "<br>";
            //echo "<br>";
            //var_dump($arrParam);
            //var_dump($class);
            //echo "<br>";
            $sth = $this->dbh->prepare($sql);
            //var_dump($sth);
            
            if ($res = $sth->execute($arrParam)){//true или false
                    return $sth->fetchAll(\PDO::FETCH_ASSOC);//Получаем массив, состоящий из объектов класса
            }else{
                    throw new \Application\Exceptions\Db('Ошибка в запросе select: ' . $sql);
                    //return [];
            }
	}
        
	/*
	 * Метод queryEach() используем для выполнения запросов с возвращением данных в качестве генератора
	 */
	public function queryEach($sql, $class, $arrParam = [])
	{
		$sth = $this->dbh->prepare($sql);
		if ($sth->execute($arrParam)){//true или false
			$sth->setFetchMode(\PDO::FETCH_CLASS, $class);
			while($res = $sth->fetch()){
				yield $res;
			}
		}else{
			throw new \Application\Exceptions\Db('Ошибка в запросе.');
			//return [];
		}
	}
	
	public function lastInsertId()
	{
		return $this->dbh->lastInsertId();
	}
}