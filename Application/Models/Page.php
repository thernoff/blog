<?php

namespace Application\Models;

use Application\Model;
use Application\Models\User;
use Application\Db;
use Application\Core\MultiException;

class Page extends Model{
    const TABLE = 'blog_pages';
    
    public $id_parent;
    public $alias;
    public $path;
    public $title;
    public $short_description;
    public $main_image;
    public $content;
    public $keywords;
    public $description;
    public $is_active;
    public $is_main;
    
    public static function findAll($sort = 'DESC')
    {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' ORDER BY id DESC', static::class);
        
        return $res;
    }
    
    /*
     * Метод возвращающий записи для главной страницы
     */
    public static function findAllMain()
    {
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE is_main = "1" AND is_active = "1" ORDER BY id DESC', static::class);
        
        return $res;
    }

    public function fillFromArray($arr)
    {		
        parent::fillFromArray($arr);
        $this->is_active = (!isset($arr['is_active']) ? 0 : 1);
        $this->is_main = (!isset($arr['is_main']) ? 0 : 1);
        $this->path = '';
    }
    
    public function getPath($id_parent)
    {
        $parentCategory = Category::findById($id_parent);
        $path .=  $parentCategory->alias . '/';
        
        if ($parentCategory->id_parent){
            $path = $this->getPath($parentCategory->id_parent) . $path;
        }
        
        return $path;
    }
    
    public function getPathRu($id_parent)
    {
        $parentCategory = Category::findById($id_parent);
        $path .=  $parentCategory->name . '/';
        
        if ($parentCategory->id_parent){
            $path = $this->getPathRu($parentCategory->id_parent) . $path;
        }
        
        return $path;
    }
    
    public function getFullUrl()
    {
        return Category::getPath($this->id_parent) . $this->alias;
    }

    public static function findByIdCategory($id_category){
        $db = Db::instance();
        $res = $db->query('SELECT * FROM ' . static::TABLE . ' WHERE id_parent = :id_category ORDER BY id DESC', static::class, [':id_category' => $id_category]);
        
        return $res;
    }
    
    public function getIntro($length = 300)
    {
        return substr($this->content, 0, $length).'...';
    }
    
    /*
     * Получаем массив, содержащий id категорий, которые являются родителями данной страницы
     */
    public function getParents(){
        return Category::getParentsId($this->id_parent);
    }
}