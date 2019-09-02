<article>
    <header class="header-image">
        <?php if ($page->main_image): ?>
            <img src="assets/upload/page/thumb/<?= $page->main_image; ?>" alt="">
        <?php endif; ?>
        <span class="publish"><?= $page->title; ?></span>
    </header>
    <h2>
        <?= $page->title; ?>
    </h2>
    <p><?= $page->content; ?></p>
    <p><a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="more">Назад</a></p>
</article>