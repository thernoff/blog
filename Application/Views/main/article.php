<article>
    <header class="header-image">
        <img src="assets/images/img1.jpg" alt="">
        <span class="publish">Published: <?= $article->author; ?> 29.09.2015</span>
    </header>
    <h2>
        <?= $article->title; ?>
    </h2>
    <p><?= $article->content; ?></p>
    <p><a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="more">Назад</a></p>
</article>