<h2><?=$this->title;?></h2>
<p><a class="btn" href="?controller=admin&method=createGallery">Создать галерею</a></p>
<div>
<?php
    echo "<br>";
    echo '<table class="admin-articles-table" width="100%">';
    echo '<tr><th align="center">ID</th><th align="center">Имя категории</th><th></th><th></th><th></th><th></th>';
    foreach ($galleries as $gallery){
            echo '<tr>';
            echo '<td align="center">' . $gallery->id . '</td>';

            echo '<td>' . $gallery->name . '</td>';
            
            echo '<td align="center"><a class="btn" href="?controller=admin&method=updateGallery&id=' . $gallery->id . '">Редактировать</a></td>';
            echo '<td align="center"><a class="btn" href="?controller=admin&method=deleteGallery&id=' . $gallery->id . '"> Удалить</a></td>';
            echo '<td align="center"><a class="btn" href="?controller=admin&method=addPhoto&id=' . $gallery->id . '">Добавить фото</a></td>';
            echo '<td align="center"><a class="btn" href="?controller=admin&method=deletePhoto&id=' . $gallery->id . '">Удалить фото</a></td>';
            echo "</tr>";
    }
    echo "</table>";
?>
</div>