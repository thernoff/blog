<?php

namespace Application\Models;

use Application\Model;
use Application\Db;
use Application\Core\MultiException;

class Tag extends Model {

    const TABLE = 'blog_tags';

    public $name;

}
