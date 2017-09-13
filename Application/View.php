<?php

namespace Application;

class View
    implements \Countable
{
    protected $data = [];

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function display($template, $view, $arrParams = [])
    {
        echo $this->render($template);
    }

    public function render($template, $view, $arrParams = [])
    {
        if (count($arrParams)>0){
            foreach ($arrParams as $key => $value){
                $$key = $value;
            }
        }
        ob_start();

        foreach ($this->data as $property => $value){
                $$property = $value;
        }
        
        include $view;

        $content = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        include $template;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    }
    
    /*
     * Метод для вывода view
     */
    
    public function displayView($view, $arrParams = [])
    {
        if (count($arrParams)>0){
            foreach ($arrParams as $key => $value){
                $$key = $value;
            }
        }
        ob_start();

        foreach ($this->data as $property => $value){
                $$property = $value;
        }
        
        include $view;

        $content = ob_get_contents();
        ob_end_clean();
               
        echo $content;
    }

        public function count()
    {
        return count($this->data);
    }
}