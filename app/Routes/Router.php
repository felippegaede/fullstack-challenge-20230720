<?php

namespace App\Routes;

class Router 
{
    private array $handlers; 

    /**
     * Adiciona uma rota GET à lista de handlers.
     *
     * @param string $path O caminho da rota.
     * @param mixed  $handler O callback ou função a ser executado quando a rota for acessada.
     */
    public function get(string $path, $handler): void
    {
        $this->addHandler('GET', $path, $handler);
    }

    /**
     * Adiciona um handler à lista de handlers.
     *
     * @param string $method O método HTTP da rota (por exemplo, GET, POST, etc.).
     * @param string $path O caminho da rota.
     * @param mixed  $handler O callback ou função a ser executado quando a rota for acessada.
     */
    private function addHandler(string $method, string $path, $handler): void 
    {
        // Cria um array associativo com informações sobre a rota, incluindo o método, caminho e callback.
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' =>  $method,
            'handler' => $handler
        ];
    }

    /**
     * Executa a rota correspondente com base na solicitação HTTP atual.
     */
    public function run(): void
    {
        // Obtém a URI da requisição atual.
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath= $requestUri['path'];
        $method= $_SERVER['REQUEST_METHOD'];
        $query = isset($requestUri['query']) ?  $requestUri['query'] : '';
        $query = $this->getQueryStringParams($query);


        $callback = null;

        // Itera pelos handlers registrados para encontrar o callback correspondente à rota.
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $method === $handler['method']){
                $callback = $handler['handler'];
            }
        }

         // Se não houver callback correspondente, retorna um erro 404.
        if (!$callback){
            header("HTTP/1.0  404 Not Found");
            return;
        }

        // Chama o callback passando os parâmetros da query string.
        call_user_func_array($callback, [$query]);
    }

    /**
     * Converte uma string de query em um array associativo de parâmetros.
     *
     * @param string $query A string da query a ser convertida.
     * @return array Um array associativo de parâmetros.
     */
    private function getQueryStringParams(string $query): array
    {
        // Inicializa um array vazio para armazenar os parâmetros da query string.
        $result = [];
    
        // Divide a query string em pares de chave-valor usando '&' como delimitador.
        $params = explode('&', $query);
    
        // Itera pelos pares de chave-valor.
        foreach ($params as $param) {
            // Divide cada par em chave e valor usando '=' como delimitador.
            $parts = explode('=', $param);
    
            // Verifica se há pelo menos dois elementos (chave e valor) em cada par.
            if (count($parts) >= 2) {
                list($key, $value) = $parts;    
                $result[$key] = $value;
            }
        }
    
        return $result;
    }
}