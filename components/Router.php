<?php


class Router {
    private $routes;
    
    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }
    
    /**
     * Returns request string
     * @return string
     */
    private function getUri(){
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


    public function run() {
        // Получить строку запроса
        $uri = $this->getUri();
        
        // Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern =>$path){
            
            //сравниваем $yriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
                
                //определить какой контроллер
                //и экшн обрабатывают запрос
                
                $segments = explode('/', $path);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                
                $actionName = 'action' . ucfirst(array_shift($segments));
                
                // Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                
                if (file_exists($controllerFile)) {
                    include_once $controllerFile;
                }
                // Создать обьект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
            
        }
        
    }
    
}
