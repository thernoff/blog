<?php

require __DIR__ . '/autoload.php';
use Application\Models\Article;
//$article = new Article();
//$article = Article::findById('1');
$article = Article::findAll();
var_dump($article);