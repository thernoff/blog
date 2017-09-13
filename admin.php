<?php

use Application\Models\News;
//use Application\Config;

require __DIR__ . '/autoload.php';

if ($_POST['submit'] == "Добавить"){
	$title = $_POST['title'];
	$text = $_POST['text'];
	$author = 1;
	$news = new News();
	$news->title = $title;
	$news->text = $text;
	$news->author = $author;
	$news->save();
	header("Location: admin.php");
}

if ($_POST['submit'] == "Обновить"){
	$id = $_POST['id'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$author = 1;
	$news = News::findById($id);
	$news->title = $title;
	$news->text = $text;
	$news->author = $author;
	$news->save();
	header("Location: admin.php");
}

if (!empty($_GET)){
	$controller = $_GET['controller'];//create, update, delete
	
	if ("create" == $controller){
		$submitValue = "Добавить";
		require 'Application/Views/admin/form.php';
	}
	
	if ("update" == $controller){
		$submitValue = "Обновить";
		$id = $_GET['id'];
		$news = News::findById($id);
		$title = $news->title;
		$text = $news->text;
		require 'Application/Views/admin/form.php';
	}
	
	if ("delete" == $controller){
		$id = $_GET['id'];
		$news = News::findById($id);
		$news->delete();
		header("Location: admin.php");
	}
}

require 'Application/Views/admin/admin.php';

$allNews = News::findAll();
//var_dump($allNews);
//var_dump($_POST);
require 'Application/Views/admin/listnews.php';