<?php

namespace Application\Controllers;

use Application\View;
use Application\Controller;
use Application\MultiException;

class News
	extends Controller
{
	protected function actionIndex()
	{
		
		$this->view->title = "Мой сайт";
		$news = \Application\Models\News::findAll();
		$this->view->news = $news;
		echo $this->view->render(__DIR__ . '/../templates/index.php');
	}
	
	protected function actionArticle()
	{
		$id = (int)$_GET['id'];		
		$this->view->title = "Мой сайт";		
		$article = \Application\Models\News::findById($id);
		$this->view->article = $article;
		echo $this->view->render(__DIR__ . '/../templates/article.php');
	}
	
	protected function actionCreate()
	{
		try{
			$article = new \Application\Models\News();
			$article->fill([
					'title' => 'Коллегия судей проверит постановление, возмутившее Путина',
					'text' => 'Квалификационная коллегия судей проверит постановление мирового судьи, 
					которое вызвало возмущение президента Владимира Путина. Об этом РИА Новости сообщили 
					в Управлении судебного департамента в Липецкой области.',
					'author' => 'bobo'
			]);
		} catch (MultiException $e){
			$this->view->errors = $e;
		}
		$this->view->article = $article;
		$this->view->display(__DIR__ . '/../templates/create.php');
	}
}