<?php

namespace Application\Controllers;

use Application\View;
use Application\Controller;
use Application\Exceptions\Core;
use Application\Exceptions\Db;
use Application\Models\User;
use Application\Models\Session;

class Main
    extends Controller
{
    protected function beforeAction()
    {

    }
    
    protected function actionIndex()
    {
        $this->view->title = "Мой сайт";
        $currentPage = (!empty($_GET['page'])) ? (int)$_GET['page'] : 1;
        $max = 5;
        $pages = \Application\Models\Page::findAllMain();
        $total = count($pages);
        $pagination = new \Application\Components\Pagination($currentPage, $max, $total, $pages);
        $pages = $pagination->getPages();
        $this->view->pages = $pages;
        $prev = $currentPage - 1;
        $next = $currentPage + 1;
        $this->view->linkPrev = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&page=" . $prev;
        $this->view->linkNext = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&page=" . $next;
        $this->view->pagination = $pagination;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/index.php');
    }
    
    protected function actionArticle()
    {
        if (!empty($_GET['id'])){
            $id_article = (int)$_GET['id'];
            if ($article = \Application\Models\Article::findById($id_article)){           
                $this->view->article = $article;
                echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/article.php');
            }else{
                $this->actionError404();
            }
        }else{
            $this->actionError404();
        }
    }
    
    protected function actionPage()
    {
        if (!empty($_GET['id'])){
            $id_page = (int)$_GET['id'];
            if ($page = \Application\Models\Page::findById($id_page)){           
                $this->view->page = $page;
                echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/page.php');
            }else{
                $this->actionError404();
            }
        }else{
            $this->actionError404();
        }
    }
    
    protected function actionCategory()
    {
        if (!empty($_GET['id'])){
            $id_category = (int)$_GET['id'];
            if ($pages = \Application\Models\Page::findByIdCategory($id_category)){
                $currentPage = (!empty($_GET['page'])) ? (int)$_GET['page'] : 1;
                $max = 5;
                $total = count($pages);
                $pagination = new \Application\Components\Pagination($currentPage, $max, $total, $pages);
                $pages = $pagination->getPages();
                $this->view->pages = $pages;
                $prev = $currentPage - 1;
                $next = $currentPage + 1;
                $this->view->linkPrev = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&id=" . $id_category . "&page=" . $prev;
                $this->view->linkNext = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&id=" . $id_category . "&page=" . $next;
                $this->view->pagination = $pagination;
                echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/category.php');
            }else{
                $this->actionError404();
            }
        }else{
            $this->actionError404();
        }
    }

    protected function actionGallery()
    {
        $this->view->title = "Фотогалереи";
        $galleries = \Application\Models\Gallery::findAllIsActive();
        $this->view->galleries = $galleries;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/gallery.php');
    }
    
    protected function actionViewGallery(){
        if (!empty($_GET['id'])){
            $id_gallery = (int)$_GET['id'];
            $gallery = \Application\Models\Gallery::findById($id_gallery);
            if ($images = \Application\Models\Image::getImagesByGallery($id_gallery)){           
                $this->view->images = $images;
                $this->view->gallery = $gallery;
                echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/view-gallery.php');
            }else{
                $this->actionError404();
            }
        }else{
            $this->actionError404();
        }
    }

    protected function actionAutorize()
    {
        $this->view->title = "Мой сайт";    
        $user = User::instance();
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        if ($login && $password){
            
            if ($user->login($login, $password)){
                $referer = Session::getSessionData('referer');
                if ($referer != null) {
                    header("Location: ".$referer);
                }else{
                    header("Location: /");
                }
            }else{
                $this->view->error = "Не верно введены логин или пароль.";
                
                echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/autorize.php');
            }
        }else{
            $this->view->user = $user->getUser();
            
            echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/autorize.php');
        }
    }
    
    protected function actionSearch(){
        $this->view->title = "Результаты поиска";
        
        if (!empty($_POST['search'])){
            $search = htmlspecialchars($_POST['search']);
            $pages = \Application\Models\Page::search('content', $search);
            $this->view->pages = $pages;
            echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/search.php');
        }else{
            $this->actionError404();
        }
    }

    protected function actionError404()
    {
        echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/error404.php');
    }


    protected function actionLogout()
    {
        $user = User::instance();
        $user->logout();
    }
}