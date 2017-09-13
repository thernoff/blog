<?php

namespace Application\Models;

use Application\Model;
use Application\Db;

class Menu extends Model{
    const TABLE = 'blog_menus';
    public $name;
    public $alias;
    
    public $is_active;    
    
    public function fillFromArray($arr)
    {		
        parent::fillFromArray($arr);
        
        $this->is_active = (!isset($arr['is_active']) ? 0 : 1);
    }
    
    public function getItems(){
        $db = Db::instance();
        $sql = 'SELECT * FROM blog_menu_items WHERE id_menu = :id_menu';
        $res = $db->select($sql, [':id_menu' => $this->id]);
        return ($res) ? $res : [];
    }
    
    public function saveItems($arrItems)
    {
        $db = Db::instance();
        $sql = 'DELETE FROM blog_menu_items WHERE id_menu = :id_menu';
        $db->execute($sql, [':id_menu' => $this->id]);
        //echo "<pre>";
        //var_dump($_POST);
        //echo $this->id."<br>";
        //var_dump($arrItems);
        //echo "</pre>";

        foreach ($arrItems as $item){
            //INSERT INTO articles_tags (id_article, id_tag) VALUES(:id_article, :tag)
            $sql = "INSERT INTO blog_menu_items (id_menu, id_category, id_page, name_item) VALUES (:id_menu, :id_category, :id_page, :name_item)";
            //var_dump([':id_menu' => $this->id, ':id_category' => $item['id_category'], ':id_page' => $item['id_page']]);
            
            $db->execute($sql, 
                [
                    ':id_menu' => $this->id, 
                    ':id_category' => $item['id_category'], 
                    ':id_page' => $item['id_page'], 
                    ':name_item' => $item['name_item']
            ]);
            //echo "<pre>";
            //var_dump([':id_menu' => $this->id, ':id_category' => $item['id_category'], ':id_page' => $item['id_page']]);
            //var_dump($item);
            //echo "</pre>";
        }                    
    }
    
    public function delete()
    {
        $db = Db::instance();
        $sql = "DELETE FROM " . blog_menu_items . " WHERE id_menu = :id_menu";
        $db->execute($sql, [":id_menu" => $this->id]);
        parent::delete();
    }
}
?>