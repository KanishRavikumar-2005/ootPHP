<?php
class Router {
    private static $routes = [];
    private static $namedRoutes = [];
    public static $VARIABLE_STORE = [];

    // Add a route with a pattern, callback, HTTP methods, and optional name
    public static function add($pattern, $callback, $methods = ['GET'], $name = null) {
        self::$routes[] = [
            'pattern' => $pattern,
            'callback' => $callback,
            'methods' => $methods,
            'name' => $name
        ];

        if ($name) {
            self::$namedRoutes[$name] = $pattern;
        }
    }

    // Route requests based on the provided route names
    public static function route($routeNames = []) {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($uri, '?');

        // Filter routes based on provided route names
        $routesToCheck = array_filter(self::$routes, function($route) use ($routeNames) {
            return empty($routeNames) || in_array($route['name'], $routeNames);
        });

        foreach ($routesToCheck as $route) {
            if (!in_array($method, $route['methods'])) {
                continue;
            }

            // Convert pattern to regex
            $pattern = preg_replace('/<([^>]+)>/', '([^/]+)', $route['pattern']);
            $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        // Handle 404 Not Found
        http_response_code(404);
        include $_SERVER['DOCUMENT_ROOT']."/.config/_404.php";
    }

    public static function path($string, $options = []) {
        // Default base path (you can change this as needed)
        $basePath = $_SERVER['DOCUMENT_ROOT'];

        // Create the full path by concatenating the base path with the given string
        $fullPath = rtrim($basePath, '/') . '/' . ltrim($string, '/');

        // Check options for different return types
        if (isset($options['returnType'])) {
            switch ($options['returnType']) {
                case 'absolute':
                    // Return the absolute path
                    return $fullPath;
                case 'relative':
                    // Return the relative path (remove document root)
                    return ltrim(str_replace($basePath, '', $fullPath), '/');
                case 'url':
                    // Return the URL path
                    return 'http://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($string, '/');
                default:
                    // Return the full path by default
                    return $fullPath;
            }
        }

        // Return the full path by default if no options are provided
        return $fullPath;
    }

    // Generate a URL for a named route with optional parameters
    public static function url($name, $params = []) {
        if (!isset(self::$namedRoutes[$name])) {
            throw new Exception("No route found with name $name");
        }

        $pattern = self::$namedRoutes[$name];

        foreach ($params as $key => $value) {
            $pattern = str_replace("<$key>", $value, $pattern);
        }

        // Remove any remaining placeholders
        $pattern = preg_replace('/<[^>]+>/', '', $pattern);
        return $pattern;
    }
}
?>
