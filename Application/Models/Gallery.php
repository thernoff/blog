<?php

namespace Application\Models;

use Application\Model;
use Application\Db;
use Application\Core\MultiException;

class Gallery
    extends \Application\Model
{
    const TABLE = 'blog_galleries';
    
    public $name;
    public $description;
    public $alias;
    public $is_active;
    
    public function getFirstImage()
    {
        $db = Db::instance();
        $sql = "SELECT * FROM blog_images WHERE id_gallery = :id_gallery ORDER BY id";
        $images = $db->select($sql, [":id_gallery" => $this->id]);
        
        return $images[0];
    }
    
    public function fillFromArray($arr)
    {		
        parent::fillFromArray($arr);        
        $this->is_active = (!isset($arr['is_active']) ? 0 : 1);
    }
}