<?php 
// this class is responsible of redirecting the uri request to the the desired controller file
// you use this class in the routes.php file, but DO NOT come near this class.
namespace Core;
use Core\Middleware\Middleware;

class Router {
    protected $routes =[];

    protected function add($method,$uri,$controller) 
    {
        $this->routes[] = array_merge(compact('method', 'uri', 'controller'), ['middleware' => null]);
        return $this;
    }
    
    public function get($uri,$controller) 
    {
        return $this->add('GET',$uri,$controller);
    }
    
    public function post($uri,$controller) 
    {
        return $this->add('POST',$uri,$controller);
    }
    
    public function destroy($uri,$controller) 
    {
        return $this->add('DESTROY',$uri,$controller);
    }
    
    public function put($uri,$controller) 
    {
        return $this->add('PUT',$uri,$controller);
    }
    
    public function patch($uri,$controller) 
    {
        return $this->add('PATCH',$uri,$controller);
    }
    
    public function only($key) 
    {
        $this->routes[array_key_last($this->routes)]['middleware']=$key;
    }

    public function route($uri,$method) 
    {
        foreach ($this->routes as $route) {
            if($route['uri']===$uri && $route['method']===strtoupper($method)) {
                Middleware::resolve($route['middleware']);
                return require base_path('Http/controllers/' . $route['controller']);
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