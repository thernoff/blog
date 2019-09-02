<?php

function printListTree($map, $shift = 0) {
    if (!empty($map)) {
        echo "<ul>";
        foreach ($map as $section) {
            ?>
            <li>
                <?php for ($i = 0; $i < $shift; $i++)
                    echo '&nbsp;'; ?>
                <?php
                echo "<span>" . $section['name'] . "</span>";
                echo "<span><a class='btn' href='?controller=admin&method=updateCategory&id=" . $section['id'] . "'>Редактировать</span></a>";
                if (count($section['children']) == 0) {
                    echo "<span><a class='btn' href='?controller=admin&method=deleteCategory&id=" . $section['id'] . "'> Удалить</a></span>";
                }
                ?>
                <?php
                printListTree($section['children'], $shift);
                echo "</li>";
            };
            echo "</ul>";
        }
    }
    ?>
    <h2><?= $this->title; ?></h2>
    <p><a class="btn" href="?controller=admin&method=createCategory">Добавить категорию</a></p>
    <div class="admin">
        <?php
        printListTree($map);
        ?>
    </div>