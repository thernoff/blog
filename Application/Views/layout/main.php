<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="assets/css/style-add.css" />
<link rel="stylesheet" type="text/css" href="assets/css/gallery.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=cyrillic" rel="stylesheet">
<title>Company name - home page</title>
</head>

<body>
<header class="header">
    <div class="center-block-main">
        <a href="/"><img src="assets/images/logo.png" alt="" class="logo" /></a>
        <nav class="menu-top">
            <ul>
                <li>
                    <a href="/index.php?controller=main&action=gallery">Фотогалерея</a>
                </li>
                <li>
                    <a href="/index.php?controller=main&action=page&id=16">Контакты</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="center-block-main content">
    <main>
        <?php echo $content;?>
    </main>
    <aside>
        <div class="widget">
            <h2>Меню</h2>
            <nav class="menu">
                <?= Application\Widgets\Menu\WidgetMenu::display(20);?>
            </nav>
        </div>
        <div class="widget">
            <h2>Поиск по сайту</h2>
            <form action="/index.php?controller=main&action=search" method="post">
                <input type="search" class="search" name="search" placeholder="Что ищем?">
                
            </form>
        </div>
        <!--<div class="widget">
            <h2>Categories</h2>
            <nav>
                <ul>
                    <li><a href="#">Weekend</a></li>
                    <li><a href="#">Nature</a></li>
                    <li><a href="#">Work</a></li>
                    <li><a href="#">Holiday</a></li>
                </ul>
            </nav>
        </div>-->
        <!--<div class="widget">
           <h2>Stay tuned</h2>
            <div class="subscribe">
                <form action="#" method="get">
                    <input type="email" placeholder="Your Email" class="subscribe-input">
                    <input type="image" src="assets/images/sbcr-btn.jpg" class="subscribe-image">
                </form>
            </div>
        </div>-->
        <div class="widget">
            <img src="assets/images/banner.jpg" alt="">
        </div>
    </aside>
    <div class="clear"></div>
    <?php if ($pagination): ?>
        <div class="pager clearfix">
            <?php if ($pagination->showPrev()): ?>
                <p class="previous-link">&larr; <a href="<?= $this->linkPrev; ?>">Previous</a></p>
            <?php endif; ?>
            <?php if ($pagination->showNext()): ?>
                <p class="next-link"> <a href="<?= $this->linkNext; ?>">Next</a>&rarr;</p>
             <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<footer>
    <div class="center-block-main">
        <a href="/"><img src="assets/images/logo-ftr.jpg" alt=""></a>
        <p>&copy;2016 Blogin.com - All Rights Reserved</p>
    </div>
</footer>
<script src="assets/js/gallery.js"></script>
</body>
</html>
