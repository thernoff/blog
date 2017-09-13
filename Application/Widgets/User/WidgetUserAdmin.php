<?php

namespace Application\Widgets\User;

use Application\Controller;
use Application\Models\User;
class WidgetUserAdmin
    extends Controller
{
    public static function display(){
        //Получаем текущего пользователя
        $user = User::instance()->getUser();
        //$this->view->user = $user;
        //$this->view->displayView(__DIR__ . '/../Views/admin/index.php');
        //$this->view->displayView('widget-user-admin.php');
        include_once 'widget-user-admin.php';
    }
}