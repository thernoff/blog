<h2><?=$this->title;?></h2>
<p><a class="btn" href="?controller=admin&method=createMenu">Добавить меню</a></p>
<div>
<?php
    echo "<br>";
    echo '<table class="admin-articles-table" width="100%">';
    echo '<tr><th align="center">ID</th><th>Название меню</th><th></th><th></th>';
    foreach ($menus as $menu){
            echo '<tr>';
            echo '<td align="center">' . $menu->id . '</td>';

            echo '<td>' . $menu->name . '</td>';
            
            echo '<td align="center"><a class="btn" href="?controller=admin&method=updateMenu&id=' . $menu->id . '">Редактировать</a></td>';
            echo '<td align="center"><a class="btn" href="?controller=admin&method=deleteMenu&id=' . $menu->id . '"> Удалить</a></td>';
            echo '</tr>';
    }
    echo '</table>';
?>
</div>