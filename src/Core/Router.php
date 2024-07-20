<?php
namespace Apps\Core;

use Apps\App\Controllers\ErrorController;
use ReflectionClass;
use ReflectionException;

class Router
{
    private static $routes = [];

    public function __construct(array $routes = [])
    {
        self::$routes = $routes;
    }

    public static function create(string $uri, string $method)
    {
        foreach (self::$routes as $route => $config) {
            $regex = '#^' . str_replace('/', '\/', $route) . '$#';
            if (preg_match($regex, $uri, $matches) && $config['method'] === $method) {
                $controllerName = $config['controller'];
                $action = $config['action'];
                $controllerClass = 'Apps\\App\\Controllers\\' . ucfirst($controllerName);
                try {
                    $reflectionClass = new ReflectionClass($controllerClass);
                    $controllerInstance = $reflectionClass->newInstance();
                    
                    if (!$reflectionClass->hasMethod($action)) {
                        throw new ReflectionException("La méthode $action n'existe pas dans le contrôleur $controllerClass");
                    }
                    
                    $reflectionMethod = $reflectionClass->getMethod($action);
                    $reflectionMethod->invoke($controllerInstance);
                    return;
                } catch (ReflectionException $e) {
                    echo "Erreur de réflexion : " . $e->getMessage();
                    self::handleError();
                    return;
                }
            }
        }
        self::handleError();
    }

    public static function get(string $uri, string $controller, string $action)
    {
        self::$routes[$uri] = [
            'method' => 'GET',
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public static function post(string $uri, string $controller, string $action)
    {
        self::$routes[$uri] = [
            'method' => 'POST',
            'controller' => $controller,
            'action' => $action,
        ];
    }

    private static function handleError()
    {
        $errorController = new ErrorController();
        $errorController->Error_404();
    }
}
?>