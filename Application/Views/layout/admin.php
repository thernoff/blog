<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
<link rel="stylesheet" type="text/css" href="assets/css/style-admin.css" />
<link rel="stylesheet" type="text/css" href="assets/css/style-add.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=cyrillic" rel="stylesheet">
<script src="assets/ckeditor/ckeditor.js"></script>
<title>Блог туриста: управление сайтом</title>
</head>

<body>
<header class="header">
    <div class="center-block-main">
        <a href="/index.php?controller=admin"><img src="assets/images/logo-admin.png" alt="" class="logo" /></a>
        <nav class="menu-top">
            <ul>
                <li>
                    <a href="/index.php?controller=admin">Статьи</a>                    
                </li>
                <li>
                    <a href="/index.php?controller=admin&method=Category">Категории</a>
                </li>
                <li>
                    <a href="/index.php?controller=admin&method=Menu">Меню</a>
                </li>
                <li>
                    <a href="/index.php?controller=admin&method=Gallery">Галереи</a>
                    <li>
                    <a href="/index.php?controller=admin&method=Logout">Выйти</a>
                </li>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="center-block-main content">
    <main>
        <?php echo $content;?>
    </main>
    <!--<aside>
        <div class="widget">
            <?php //echo Application\Widgets\User\WidgetUserAdmin::display();?>
        </div>
        
        <div class="widget">
            <h2><a href="?controller=admin&method=category">Категории</a></h2>
            <nav>
                <ul>
                    <li><a href="?controller=admin&method=createCategory">Создать</a></li>
                </ul>
            </nav>
        </div>
    </aside>-->
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
<script src="assets/js/functions.js"></script>

</body>
</html>
