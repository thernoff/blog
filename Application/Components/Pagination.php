<?php

namespace Application\Components;

class Pagination
{
    public $currentPage;
    public $max;
    public $total;
    public $arrPages;
    
    public function __construct($currentPage, $max, $total, $arrPages) {
        $this->currentPage = (int)$currentPage;
        $this->max = (int)$max;
        $this->total = (int)$total;
        $this->arrPages = $arrPages;
    }
    
    public function getPages(){
        $end = min($this->total, $this->currentPage * $this->max);
        $pages = [];
        for ($i = ($this->currentPage - 1) * $this->max; $i < $end; $i++){
            $pages[] = $this->arrPages[$i];
        }
        
        return $pages;
    }
    
    public function showNext()
    {
        if ($this->total <= $this->currentPage * $this->max){
            return false;
        }
        return true;
    }
    
    public function showPrev()
    {
        if ($this->currentPage > 1){
            return true;
        }
        return false;
    }
}
