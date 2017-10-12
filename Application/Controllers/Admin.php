<?php

namespace Application\Controllers;

use Application\View;
use Application\Controller;
use Application\Exceptions\Core;
use Application\Exceptions\Db;
use Application\Models\User;
use Application\Models\Session;
use Application\Models\Tag;

class Admin
    extends Controller
{
    private $user;
    private $errors = [];
    
    protected function beforeAction()
    {
        $this->user = User::instance()->getUser();
        if (!$this->user->isAutorize()){
            Session::setSessionData('referer', $_SERVER['REQUEST_URI']);
            header("Location: /index.php?controller=main&action=autorize");
        }
    }
    
    protected function actionLogout()
    {
        $user = User::instance();
        $user->logout();
    }
    
    protected function actionIndex()
    {
        $this->view->title = "Менеджер статей";
        $currentPage = (!empty($_GET['page'])) ? (int)$_GET['page'] : 1;
        $max = 10;
        $pages = \Application\Models\Page::findAll();
        $total = count($pages);
        $pagination = new \Application\Components\Pagination($currentPage, $max, $total, $pages);
        $pages = $pagination->getPages();
        $this->view->pages = $pages;
        $prev = $currentPage - 1;
        $next = $currentPage + 1;
        $this->view->linkPrev = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&page=" . $prev;
        $this->view->linkNext = "/index.php?controller=" . $this->controllerName . "&action=" . $this->actionName . "&page=" . $next;
        $this->view->pagination = $pagination;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/index.php');
    }
    
    protected function actionCreateArticle()
    {
        if (isset($_POST['submitCreate'])){
            $article = new \Application\Models\Article();
            $article->title = htmlspecialchars($_POST['title']);
            $article->content = $_POST['content'];
            $article->id_user = $this->user->id;    
            $article->save();
            header("Location: /index.php?controller=admin&action=index");
        }
        
        $allTags = Tag::findAll();
        $this->view->allTags = $allTags;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-create-article.php');
    }

    protected function actionUpdateArticle()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        if (isset($_POST['submitUpdate'])){
            $article = new \Application\Models\Article();
            $article->id = $_POST['id'];
            $article->title = htmlspecialchars($_POST['title']);
            $article->content = $_POST['content'];
            $article->id_user = $this->user->id;    
            $article->save();
            $article->saveTags($_POST['tags']);
            header("Location: /index.php?controller=admin&action=index");                       
        }
        
        $article = \Application\Models\Article::findById($id);
        $checkedTags = $article->getTags();
        $allTags = Tag::findAll();
        $this->view->article = $article;
        $this->view->checkedTags = $checkedTags;
        $this->view->allTags = $allTags;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-edit-article.php');
    }
    
    protected function actionDeleteArticle()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $article = \Application\Models\Article::findById($id);
        $article->delete();
        
        header("Location: /index.php?controller=admin&action=index");
    }
    
    /*-------------------------------------------------------------------------------*/
    /*----------------------------------Page-----------------------------------------*/
    /*-------------------------------------------------------------------------------*/
    protected function actionCreatePage()
    {
        $this->view->title = "Создание страницы";
        $page = new \Application\Models\Page();
        
        if (isset($_POST['submitCreate'])){
            $page->fillFromArray($_POST);
            $page->path = $page->getFullUrl();
            if (\Application\Components\Validator::validateEmpty($_POST)){
                if ($_FILES["uploadfile"]["name"]){
                    $config = \Application\Core\Config::instance()->data;
                    $path_main_image = $config['page']['path_main_image'];
                    $path_main_image_thumb = $config['page']['path_main_image_thumb'];
                    $image = new \Application\Models\Image();
                    $image->name = $_FILES["uploadfile"]["name"];
                    $image->load($_FILES["uploadfile"]["tmp_name"], $path_main_image);
                    $width = $config['page']['width_main_image'];
                    $height = $config['page']['height_main_image'];
                    if ($image->createThumbnail($path_main_image, $path_main_image_thumb, $image->name, $width, $height)){
                        $page->main_image = $image->name;
                    };
                }
                $page->save();
                header("Location: /index.php?controller=admin&action=index");
            }else{
                $this->errors[] = "Заполните все поля";
            }
        }
        
        $this->view->errors = $this->errors;
        $this->view->page = $page;
        $map = $page->getTree('blog_categories');
        $this->view->map = $map;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-create-page.php');
    }
    
    protected function actionUpdatePage()
    {
        $this->view->title = "Редактирование страницы";
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }

        if (isset($_POST['submitUpdate'])){
            $id = $_POST['id'];
            $page = \Application\Models\Page::findById($id);
            $page->fillFromArray($_POST);
            $page->path = $page->getFullUrl();
            if (\Application\Components\Validator::validateEmpty($_POST)){
                if ($_FILES["uploadfile"]["name"]){
                    $config = \Application\Core\Config::instance()->data;
                    $path_main_image = $config['page']['path_main_image'];
                    $path_main_image_thumb = $config['page']['path_main_image_thumb'];
                    $image = new \Application\Models\Image();
                    $image->name = $_FILES["uploadfile"]["name"];
                    $image->load($_FILES["uploadfile"]["tmp_name"], $path_main_image);
                    $width = $config['page']['width_main_image'];
                    $height = $config['page']['height_main_image'];
                    if ($image->createThumbnail($path_main_image, $path_main_image_thumb, $image->name, $width, $height)){
                        if ($page->main_image && file_exists($path_main_image_thumb . $page->main_image)){
                            unlink($path_main_image_thumb . $page->main_image);
                        }
                        if ($page->main_image && file_exists($path_main_image . $page->main_image)){
                            unlink($path_main_image . $page->main_image);
                        }
                        $page->main_image = $image->name;
                    };
                }
                $page->save();
                header("Location: /index.php?controller=admin&action=index");
            }else{
                $this->errors[] = "Заполните все поля";
            }
        }
        
        $this->view->errors = $this->errors;
        $page = \Application\Models\Page::findById($id);
        $this->view->page = $page;
        $map = $page->getTree('blog_categories');
        $this->view->map = $map;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-update-page.php');
    }
    
    protected function actionDeletePage()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $page = \Application\Models\Page::findById($id);
        $page->delete();
        
        header("Location: /index.php?controller=admin&action=index");
    }
    /*-------------------------------------------------------------------------------*/
    /*----------------------------------Category-------------------------------------*/
    /*-------------------------------------------------------------------------------*/
    protected function actionCategory()
    {
        $this->view->title = "Менеджер категорий";
        $categories = \Application\Models\Category::findAll();
        $this->view->categories = $categories;
        $map = \Application\Models\Category::makeTree('blog_categories');
        $this->view->map = $map;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/category.php');
    }
    
    
    protected function actionCreateCategory()
    {
        $this->view->title = "Создание категории";
        $category = new \Application\Models\Category();
        
        if (isset($_POST['submitCreate'])){
                
                $category->fillFromArray($_POST);               
                if (\Application\Components\Validator::validateEmpty($_POST)){
                    $category->save();
                    header("Location: /index.php?controller=admin&action=category");
                }else{
                    $this->errors[] = "Заполните все поля";
                }
        }
        
        $this->view->errors = $this->errors;
        $this->view->category = $category;
        $map = $category->getTree();
        $this->view->map = $map;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-create-category.php');
    }
    
    protected function actionUpdateCategory()
    {
        $this->view->title = "Редактирование категории";
        
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $category = \Application\Models\Category::findById($id);
        
        if (isset($_POST['submitCreate'])){
                
            $category->fillFromArray($_POST);               
            if (\Application\Components\Validator::validateEmpty($_POST)){
                $category->id = $_POST['id'];
                $category->save();
                \Application\Models\Category::updateFullUrl($category->id);
                header("Location: /index.php?controller=admin&action=category");
            }else{
                $this->errors[] = "Заполните все поля";
            }
        }
        
        $this->view->errors = $this->errors;
        $this->view->category = $category;
        $map = $category->getTree();
        $this->view->map = $map;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-update-category.php');
    }
    
    protected function actionDeleteCategory()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $category = \Application\Models\Category::findById($id);
        $category->deleteWithPages();
        
        header("Location: /index.php?controller=admin&action=category");
    }
    /*-------------------------------------------------------------------------------*/
    /*----------------------------------Menu-----------------------------------------*/
    /*-------------------------------------------------------------------------------*/
    protected function actionMenu()
    {
        $this->view->title = "Менеджер меню";
        $menus = \Application\Models\Menu::findAll();
        $this->view->menus = $menus;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/menu.php');
    }
    
    protected function actionCreateMenu()
    {
        $this->view->title = "Создание меню";
        $menu = new \Application\Models\Menu();
        
        if (isset($_POST['submitCreate'])){    
            $menu->fillFromArray($_POST);
            
            if (\Application\Components\Validator::validateEmpty($_POST)){
                $arrItems = [];
                for($i=0; $i<count($_POST['ids_parent']); $i++){
                    if ($_POST['name_item'][$i]){
                        $arrItems[$i]['name_item'] = $_POST['name_item'][$i];
                        $arrItems[$i]['id_category'] = $_POST['ids_parent'][$i];
                        $arrItems[$i]['id_page'] = $_POST['ids_page'][$i];
                    }
                }
                $menu->save();
                
                try{
                    $menu->saveItems($arrItems);
                } catch (Db $ex) {
                    $this->errors[] = "Пункты меню должны быть уникальными.";
                }
                header("Location: /index.php?controller=admin&action=menu");
            }else{
                $this->errors[] = "Заполните все поля";
            }        
        }
        
        $this->view->errors = $this->errors;
        $this->view->menu = $menu;
        $map = \Application\Models\Menu::makeTree('blog_categories');
        $this->view->map = $map;
        $pages = \Application\Models\Page::findAll();
        $this->view->pages = $pages;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-create-menu.php');
    }
    
    protected function actionUpdateMenu()
    {
        $this->view->title = "Редактирование меню";
        
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $menu = \Application\Models\Menu::findById($id);
        
        if (isset($_POST['submitCreate'])){
            $menu->fillFromArray($_POST);               
            if (\Application\Components\Validator::validateEmpty($_POST)){
                $arrItems = [];
                for($i=0; $i<count($_POST['ids_parent']); $i++){
                    if ($_POST['name_item'][$i]){
                        $arrItems[$i]['name_item'] = $_POST['name_item'][$i];
                        $arrItems[$i]['id_category'] = $_POST['ids_parent'][$i];
                        $arrItems[$i]['id_page'] = $_POST['ids_page'][$i];
                    }  
                }
                $menu->save();
                try{
                    $menu->saveItems($arrItems);
                } catch (Db $ex) {
                    $this->errors[] = "Пункты меню должны быть уникальными.";
                }
                header("Location: /index.php?controller=admin&action=menu");
            }else{
                $this->errors[] = "Укажите имя меню";
            }
                 
        }
        
        $this->view->errors = $this->errors;
        $this->view->menu = $menu;
        $this->view->items = $menu->getItems();
        $map = \Application\Models\Menu::makeTree('blog_categories');
        $this->view->map = $map;        
        $pages = \Application\Models\Page::findAll();
        $this->view->pages = $pages;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-update-menu.php');
    }
    
    protected function actionDeleteMenu()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $menu = \Application\Models\Menu::findById($id);
        $menu->delete();
        
        header("Location: /index.php?controller=admin&action=menu");
    }
    /*-------------------------------------------------------------------------------*/
    /*--------------------------------Gallery----------------------------------------*/
    /*-------------------------------------------------------------------------------*/
    protected function actionGallery()
    {
        $this->view->title = "Галереи";
        $galleries = \Application\Models\Gallery::findAll();
        $this->view->galleries = $galleries;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/gallery.php');
    }
    
    protected function actionCreateGallery()
    {
        $this->view->title = "Создание галереи";
        $gallery = new \Application\Models\Gallery();
        if (isset($_POST['submitCreate'])){
            $gallery->fillFromArray($_POST);               
            if (\Application\Components\Validator::validateEmpty($_POST)){
                $gallery->save();
                header("Location: /index.php?controller=admin&action=gallery");
            }else{
                $this->errors[] = "Заполните все поля";
            }
        }
        
        $this->view->errors = $this->errors;
        $this->view->gallery = $gallery;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-create-gallery.php');
    }
    
    protected function actionUpdateGallery()
    {
        $this->view->title = "Редактирование галереи";
        
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $gallery = \Application\Models\Gallery::findById($id);
        $images = \Application\Models\Image::findByWhere("WHERE id_gallery = :id_gallery", [':id_gallery' => $gallery->id]);
        
        if (isset($_POST['submitCreate'])){
                $gallery->fillFromArray($_POST);               
                if (\Application\Components\Validator::validateEmpty($_POST)){
                    if ($_POST["image_name"]){
                        for ($i = 0; $i < count($_POST["image_name"]); $i++){
                            $image = \Application\Models\Image::findById($_POST["image_id"][$i]);
                            $image->title = $_POST["image_title"][$i];
                            $image->alt = $_POST["image_alt"][$i];
                            $image->save();
                        }
                    }
                    $gallery->save();
                    header("Location: /index.php?controller=admin&action=gallery");
                }else{
                    $this->errors[] = "Заполните все поля";
                }
                 
        }
        
        $this->view->errors = $this->errors;
        $this->view->gallery = $gallery;
        $this->view->images = $images;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-update-gallery.php');
    }
    
    protected function actionAddPhoto(){
        $this->view->title = "Загрузка фотографий";
        $config = \Application\Core\Config::instance()->data;
        $path_upload_large = $config['gallery']['path_upload_large'];
        $path_upload_thumb = $config['gallery']['path_upload_thumb'];
        
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
            
            $gallery = \Application\Models\Gallery::findById($id);
        
            if (isset($_POST['btnSubmit'])){
                for ($i = 0; $i < count($_FILES["uploadfile"]["name"]); $i++){
                    if ($_FILES["uploadfile"]["name"][$i]){
                        $image = new \Application\Models\Image();
                        $image->name = $_FILES["uploadfile"]["name"][$i];
                        $image->id_gallery = $gallery->id;

                        $path = $path_upload_large . $gallery->alias . "/";
                        $image->loadAndSave($_FILES["uploadfile"]["tmp_name"][$i], $path);

                        $pathToImage = $path;
                        $pathToThumb = $path_upload_thumb . $gallery->alias . "/";
                        $width = 200;
                        $height = 150;
                        $image->createThumbnail($pathToImage, $pathToThumb, $image->name, $width, $height);
                    }
                }
            }
            $this->view->gallery = $gallery;
        }
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-upload-photo.php');
    }
    
    protected function actionDeletePhoto()
    {
        $this->view->title = "Удаление фотографий";
        
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $gallery = \Application\Models\Gallery::findById($id);
        $images = \Application\Models\Image::findByWhere("WHERE id_gallery = :id_gallery", [':id_gallery' => $gallery->id]);
        
        if (isset($_POST['btnSubmit'])){
            $gallery->fillFromArray($_POST);               
            if (\Application\Components\Validator::validateEmpty($_POST)){
                if ($_POST["delete_photo"]){
                    for ($i = 0; $i < count($_POST["delete_photo"]); $i++){
                        $image = \Application\Models\Image::findById($_POST["delete_photo"][$i]);
                        if (file_exists('assets/upload/gallery/large/' . $gallery->alias . "/" . $image->name)){
                            unlink('assets/upload/gallery/large/' . $gallery->alias . "/" . $image->name);
                        }
                        if (file_exists('assets/upload/gallery/thumb/' . $gallery->alias . "/" . $image->name)){
                            unlink('assets/upload/gallery/thumb/' . $gallery->alias . "/" . $image->name);
                        }
                        $image->delete();
                    }
                }
                header("Location: /index.php?controller=admin&action=gallery");
            }else{
                $this->errors[] = "Заполните все поля";
            }
        }
        
        $this->view->errors = $this->errors;
        $this->view->gallery = $gallery;
        $this->view->images = $images;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/admin.php', __DIR__ . '/../Views/admin/form-delete-photo.php');
    }
}