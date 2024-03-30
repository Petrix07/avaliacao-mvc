<?php

namespace App\Core;

/**
 * Classe responsável pelo gerenciamento de rotas do sistema
 */
class Router {

    const
        PATH_BASE            = '/avaliacao-mvc',
        NAMESPACE_CONTROLLER = "App\Controller\\";

    /**
     * Rotas cadastradas
     * @var array
     */
    private $rotas = [
        'GET'  => [],
        'POST' => []
    ];

    public function __construct() {
        $this->carregarRotas();
    }

    /**
     * Carrega as rotas configuradas no sistema
     * @return void
     */
    private function carregarRotas(): void {
        $this->addGet('/',      Router::NAMESPACE_CONTROLLER . 'HomeController@index');
        $this->addGet('/teste', Router::NAMESPACE_CONTROLLER . 'HomeController@teste');
    }

    /**
     * Adiciona uma rota "GET"
     * @param string $uri
     * @param mixed $Controller
     * @return void
     */
    public function addGet(string $uri, string $Controller): void {
        $this->rotas['GET'][$uri] = $Controller;
    }

    /**
     * Adiciona uma rota "POST""
     * @param string $uri
     * @param string $Controller
     * @return void
     */
    public function addPost(string $uri, string $Controller): void {
        $this->rotas['POST'][$uri] = $Controller;
    }

    /**
     * Direciona a requisição do usuário para o Controller respectivo
     * @param string $uri
     * @param string $requestType
     * @return string
     */
    public function direciona(string $uri, string $requestType): string {
        switch (true) {
            case $this->verificaExisteUri($uri, $requestType):
                $response = $this->executarAcao($this->rotas[$requestType][$uri]);
                break;

            case $this->isAcessoPaginaInicial($uri):
                $response = $this->executarAcao(self::NAMESPACE_CONTROLLER . 'HomeController@index');
                break;

            default:
                $response = $this->executarAcao(self::NAMESPACE_CONTROLLER . 'ErrorController@index');
        }

        return $response;
    }

    /**
     * Verifica se a "uri" informada pelo usuário está cadastrada como uma rota válida
     * @param string $uri
     * @param string $requestType
     * @return boolean
     */
    private function verificaExisteUri(string $uri, string $requestType): bool {
        return array_key_exists($uri, $this->rotas[$requestType]);
    }

    /**
     * Verifica se a "uri" informada pelo usuário deve direciona-lo a página inicial do sistema
     * @param string $uri
     * @return bool
     */
    private function isAcessoPaginaInicial(string $uri): bool {
        return $uri == '/';
    }

    protected function executarAcao($Controller) {
        $Controller = explode('@', $Controller);
        $class      = $Controller[0];
        $metodo     = $Controller[1];

        $controllerInstance = new $class();
        return $controllerInstance->$metodo();
    }
}
