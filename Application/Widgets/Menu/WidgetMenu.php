<?php

namespace Application\Widgets\Menu;

use Application\Controller;
use Application\Models\Menu;

class WidgetMenu
    extends Controller
{
    public static function display($id_menu){
        $menu = Menu::findById($id_menu);
        $items = $menu->getItems();
        include_once 'widget-menu.php';
    }
}