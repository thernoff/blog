<?php

namespace Application\Core;

class Router
{
    private function getURI()
    {
        //$_SERVER['REQUEST_URI'] - строка запроса
        // (то, что будет стоять после имени сайта, 
        // например: blog.ru/news/article, то $_SERVER['REQUEST_URI'] будет равен news/article)
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');//
        }
    }
    
    public function run(){
        $uri = $this->getURI();
        if (strpos($uri, '?')){
            $pos = strpos($uri, '?');
            $str = substr($uri, $pos+1);
            $arr = [];
            //Получаем массив с переданными параметрами,
            //причем: первый параметр - Controller, второй параметр - Action
            $arr = explode('&', $str);
            if (strpos($arr[0], '=')){
                $arrCntr = explode('=', $arr[0]);
                if ($arrCntr[0] == "controller"){
                    $controller = 'Application\\Controllers\\'.ucfirst($arrCntr[1]);
                    $controllerName = $arrCntr[1];
                }
                //var_dump($controller);
            }

            if (strpos($arr[1], '=')){
                $arrAct = explode('=', $arr[1]);
                $action = ($arrAct[1]) ? ucfirst($arrAct[1]) : '';
            }

            try{
                if(class_exists($controller)){
                    $controller = new $controller($controllerName);			
                }else{
                    throw $e1 = new \Application\Exceptions\Error404('Запрашиваемая страница не найдена (Отсутствует контроллер: ' . $controller . ')');
                }

                if (method_exists($controller, 'action'.$action) && $action){
                    $controller->action(strtolower($action));
                    die;
                }elseif(method_exists($controller, 'actionIndex')){
                    $controller->action('index');
                    die;
                }
                else{
                    throw $e2 = new \Application\Exceptions\Error404('Запрашиваемая страница не найдена (Отсутствует метод контроллера: action' . $action . ')');
                }

            } catch (\Application\Exceptions\Error404 $e1){
                $error = $e1->getMessage();
            } catch(\Application\Exceptions\Core $e){
                $error = "Возникло исключение приложения: " . $e->getMessage();
            } catch (\Application\Exceptions\Db $e){
                $error = "Проблемы с БД: " . $e->getMessage();
            } catch (\Application\Exceptions\Error404 $e2){
                $error = $e2->getMessage();
            }finally {
                require 'Application/templates/error.php';
            }
            
        }else {
            $controller = new \Application\Controllers\Main('main');
            $action = 'Index';
            $controller->action($action);
            die;
        }
    }
}