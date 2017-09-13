<?php

namespace Application;

class Controller
{
    protected $view;
    public $controllerName;
    public $actionName;
    
    public function __construct($controllerName)
    {
        $this->controllerName = $controllerName;
        $this->view = new View();
    }

    public function action($action)
    {
        $this->actionName = $action;
        $methodName = 'action' . $action;
        $this->beforeAction();
        return $this->$methodName();
    }

    protected function beforeAction()
    {
        //Какие-то действия
    }
}