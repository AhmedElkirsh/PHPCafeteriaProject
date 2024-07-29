<?php 
// this class is responsible of redirecting the uri request to the the desired controller file
// you use this class in the routes.php file, but DO NOT come near this class.
namespace Core;

class Router {
    protected $routes =[];

    protected function add($method,$uri,$controller) 
    {
        $this->routes[]= compact('method','uri','controller');
    }

    public function get($uri,$controller) 
    {
        $this->add('GET',$uri,$controller);
    }

    public function post($uri,$controller) 
    {
        $this->add('POST',$uri,$controller);
    }

    public function destroy($uri,$controller) 
    {
        $this->add('DESTROY',$uri,$controller);
    }

    public function put($uri,$controller) 
    {
        $this->add('PUT',$uri,$controller);
    }

    public function patch($uri,$controller) 
    {
        $this->add('PATCH',$uri,$controller);
    }

    public function route($uri,$method) 
    {
        foreach ($this->routes as $route) {
            if($route['uri']===$uri && $route['method']===strtoupper($method)) {
                return require base_path($route['controller']);
            }
        } 
        $this->abort();
    }

    protected function abort($uri = 404)
    {
        http_response_code($uri);
        require base_path("views/{$uri}.php");
        exit;
    }
}