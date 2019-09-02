<?php

function getLi($item) {
    $id_category = $item['id_category'];
    $id_page = $item['id_page'];
    if ($id_page) {
        return "<li><a href='index.php?controller=main&action=page&id=" . $id_page . "'>" . $item['name_item'] . "</a></li>";
    } elseif ($id_category) {
        return "<li><a href='index.php?controller=main&action=category&id=" . $id_category . "'>" . $item['name_item'] . "</a></li>";
    } else {
        return "<li><a href='index.php?controller=main'>" . $item['name_item'] . "</a></li>";
    }
}
?>
<ul>
    <?php
    foreach ($items as $item) {
        echo getLi($item);
    }
    ?>
</ul>