<?php

namespace Application\Controllers;

use Application\View;
use Application\Controller;
use Application\Exceptions\Core;
use Application\Exceptions\Db;
use Application\Models\User;
use Application\Models\Session;

class Service
    extends Controller
{
    protected function beforeAction()
    {

    }
    
    protected function actionShowElfinder()
    {
        require '/assets/elfinder/elfinder.html';
    }
}