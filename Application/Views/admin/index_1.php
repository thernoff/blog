<p><a class="new-article" href="?controller=admin&method=createArticle">Добавить статью</a></p>
<div class="admin-articles-table">
    <?php
    echo "<br>";
    echo '<table width="100%">';
    echo '<tr><th width="5%">ID</th><th width="15%">Заголовок</th><th width="50%">Начальный текст</th><th width="15%"></th><th width="15%"></th>';
    foreach ($articles as $article) {
        echo "<tr>";
        echo "<td>" . $article->id . "</td>";
        echo "<td>" . $article->title . "</td>";
        echo "<td>" . $article->getIntro(100) . "</td>";
        echo "<td><a href='?controller=admin&method=updateArticle&id=" . $article->id . "'>Редактировать</a></td>";
        echo "<td><a href='?controller=admin&method=deleteArticle&id=" . $article->id . "'> Удалить</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>