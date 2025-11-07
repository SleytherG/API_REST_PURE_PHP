<?php

require_once __DIR__ . '/RouteAttribute.php';
require_once __DIR__ . '/../Util/Helpers.php';
require_once __DIR__ . '/../Util/Constants.php';
class Router {
    private array $routes = [];

    public function registerController(string $controllerClass): void {
        $ref = new ReflectionClass($controllerClass);
        foreach ($ref -> getMethods() as $method) {
            foreach ($method -> getAttributes(Route::class) as $attr) {
                $route = $attr -> newInstance();
                $this -> routes[] = [
                  'method' => strtoupper($route -> method),
                  'path' => $route -> path,
                  'controller' => $controllerClass,
                  'action' => $method -> getName()
                ];
            }
        }
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $path = '/' . ltrim(substr($uri, strlen($basePath)), '/');

        foreach ($this -> routes as $r) {
            $pattern = "@^" . preg_replace('@\{(\w+)\}@', '(?P<\1>[^/]+)', $r['path']) . "$@";
            if ($method === $r['method'] && preg_match($pattern, $path, $matches)) {
                $controller = new $r['controller']();
                $args = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array([$controller, $r['action']], $args);
                return;
            }
        }

        sendJson(["error" => Constants::ROUTE_NOT_FOUND], HttpResponses::$NOT_FOUND -> getCode());
    }
}
