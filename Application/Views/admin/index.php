<h2><?=$this->title;?></h2>
<p><a class="btn" href="?controller=admin&method=createPage">Добавить статью</a></p>
<div>
<?php
    echo '<br>';
    echo '<table width="100%" class="admin-articles-table">';
    echo '<tr><th align="center" width="5%">ID</th><th width="35%">Заголовок</th><th width="35%">Категории</th><th width="13%"></th><th width="12%"></th>';
    foreach ($pages as $page){
            echo '<tr>';
            echo '<td align="center">' . $page->id . '</td>';
            echo '<td>' . $page->title . '</td>';
            echo '<td>' . $page->getPathRu($page->id_parent) . '</td>';
            echo '<td  align="center"><a class="btn" href="?controller=admin&method=updatePage&id=' . $page->id . '">Редактировать</a></td>';
            echo '<td align="center"><a class="btn" href="?controller=admin&method=deletePage&id=' . $page->id . '"> Удалить</a></td>';
            echo '</tr>';
    }
    echo '</table>';
?>
</div>