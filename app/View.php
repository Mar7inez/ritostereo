<?php

namespace App;

class View
{
    private $data = [];
    
    public function __construct($data = [])
    {
        $this->data = $data;
    }
    
    public function render($view, $data = [])
    {
        $data = array_merge($this->data, $data);
        extract($data);
        
        $viewPath = __DIR__ . '/views/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: $view");
        }
        
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
    
    public function section($section, $data = [])
    {
        return $this->render("section-$section", $data);
    }
    
    public function layout($layout, $content, $data = [])
    {
        $data['content'] = $content;
        return $this->render($layout, $data);
    }
}
