<h2><?=$this->title;?></h2>
<?php 
    if (count($pages) > 0) {
        echo "<div class='search-article'><p>По вашему запросу найдено: " . count($pages) . " страниц(а).</p></div>";
?>
    <?php foreach ($pages as $page): ?>
    <article>
        <h3>
            <?=$page->title;?>
        </h3>
        <p><?=$page->short_description;?></p>
        <p><a href="<?php echo "index.php?controller=main&action=page&id=" . $page->id;?>" class="more">Читать далее</a></p>
    </article>
    <?php endforeach; ?>
<?php } else {
    echo "По вашему запросу ничего не найдено.";
}?>