<?php

namespace Application\Models;

use Application\Model;
use Application\Db;

class Author extends Model
{
	const TABLE = 'blog_authors';
	public $name;
	
	public static function findByName($name)
	{
            $db = Db::instance();
            $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE name = :name', static::class, [':name' => $name]);

            if ($res[0]){
                return $res[0];
            }else{
                return false;
            }
	}
}