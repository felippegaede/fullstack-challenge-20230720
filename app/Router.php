<?php

namespace App;

class Router 
{
    private array $handlers; 

    public function get(string $path, $handler): void
    {
        $this->addHandler('GET', $path, $handler);
    }

    private function addHandler(string $method, string $path, $handler): void 
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' =>  $method,
            'handler' => $handler
        ];
    }

    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath= $requestUri['path'];
        $method= $_SERVER['REQUEST_METHOD'];

        $callback = null;
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $method === $handler['method']){
                $callback = $handler['handler'];
            }
        }

        if (!$callback){
            header("HTTP/1.0  404 Not Found");
            return;
        }

        call_user_func_array($callback, [$_GET]);
    }
}