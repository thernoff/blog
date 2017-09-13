<?php 
    function printListTree($map, $shift = 0)
    {
        if(!empty($map))
        {
            echo "<ul>";
            foreach($map as $section)
            { ?>
                <li>
                    <?php for($i = 0; $i < $shift; $i++)echo '&nbsp;';?>
                    <?php 
                        echo "<span>" . $section['name'] . "</span>";
                        echo "<span><a class='btn' href='?controller=admin&method=updateCategory&id=" . $section['id'] . "'>Редактировать</span></a>";
                        if (count($section['children']) == 0){
                            echo "<span><a class='btn' href='?controller=admin&method=deleteCategory&id=" . $section['id'] . "'> Удалить</a></span>";
                        }
                    ?>
                    <?php printListTree($section['children'], $shift);
                    echo "</li>";
            };
            echo "</ul>";
        }
    }
?>
<h2><?=$this->title;?></h2>
<p><a class="btn" href="?controller=admin&method=createCategory">Добавить категорию</a></p>
<div class="admin">
<?php
printListTree($map);
    /*echo "<br>";
    echo '<table width="100%">';
    echo '<tr><th>ID</th><th>Родительская категория</th><th>Имя категории</th><th></th><th></th>';
    foreach ($categories as $category){
            echo "<tr>";
            echo "<td>" . $category->id . "</td>";
            echo "<td>" . $category->id_parent . "</td>";
            echo "<td>" . $category->name . "</td>";
            
            echo "<td><a href='?controller=admin&method=updateCategory&id=" . $category->id . "'>Редактировать</a></td>";
            echo "<td><a href='?controller=admin&method=deleteCategory&id=" . $category->id . "'> Удалить</a></td>";
            echo "</tr>";
    }
    echo "</table>";*/
?>
</div>