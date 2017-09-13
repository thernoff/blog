<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
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
                    <a href="#">Журнал</a>                    
                </li>
                <li>
                    <a href="#">Фотогалерея</a>
                </li>
                <li>
                    <a href="#">Контакты</a>
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
            <h2>Search</h2>
            <form action="" method="get">
                <input type="search" class="search" placeholder="What are you looking for?">
            </form>
        </div>
        <div class="widget">
            <h2>Categories</h2>
            <nav>
                <ul>
                    <li><a href="#">Weekend</a></li>
                    <li><a href="#">Nature</a></li>
                    <li><a href="#">Work</a></li>
                    <li><a href="#">Holiday</a></li>
                </ul>
            </nav>
        </div>
        <div class="widget">
           <h2>Stay tuned</h2>
            <div class="subscribe">
                <form action="#" method="get">
                    <input type="email" placeholder="Your Email" class="subscribe-input">
                    <input type="image" src="assets/images/sbcr-btn.jpg" class="subscribe-image">
                </form>
            </div>
        </div>
        <div class="widget">
            <img src="assets/images/banner.jpg" alt="">
        </div>
    </aside>
    <div class="clear"></div>
    <div class="pager clearfix">
        <p class="previous-link">&larr; <a href="#">Previous</a></p>
        <p class="next-link"> <a href="#">Next</a>&rarr;</p>
    </div>
</div>
<footer>
    <div class="center-block-main">
        <a href="/"><img src="assets/images/logo-ftr.jpg" alt=""></a>
        <p>&copy;2016 Blogin.com - All Rights Reserved</p>
    </div>
</footer>
</body>
</html>
