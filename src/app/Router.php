<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function register(string $requestMethod, string $route, array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, array $action): self
    {
        $this->register('get', $route, $action);

        return $this;
    }

    public function post(string $route, array $action): self
    {
        $this->register('post', $route, $action);

        return $this;
    }

    public function put(string $route, array $action): self
    {
        $this->register('put', $route, $action);

        return $this;
    }

    public function delete(string $route, array $action): self
    {
        $this->register('delete', $route, $action);

        return $this;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = new $class;

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

}