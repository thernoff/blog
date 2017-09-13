<?php foreach ($this->pages as $page): ?>
<article>
    <header class="header-image">
        <?php if ($page->main_image):?>
            <img src="assets/upload/page/thumb/<?=$page->main_image;?>" alt="">
        <?php endif; ?>
        <span class="publish">Published: 29.09.2015</span>
    </header>
    <h2>
        <?=$page->title;?>
    </h2>
    <p><?=$page->short_description;?></p>
    <p><a href="<?php echo "index.php?controller=main&action=page&id=" . $page->id;?>" class="more">Читать далее</a></p>
</article>
<?php endforeach; ?>