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
        /* Página home */
        $this->addGet('/',                            Router::NAMESPACE_CONTROLLER . 'HomeController@index');
        /* Página home */
        $this->addGet('/home',                        Router::NAMESPACE_CONTROLLER . 'HomeController@index');
        /* Consulta de produtos */
        $this->addGet('/produtos',                    Router::NAMESPACE_CONTROLLER . 'ProdutoController@index');
        /* Página de cadastro dos produtos */
        $this->addGet('/produtos/cadastrar',          Router::NAMESPACE_CONTROLLER . 'ProdutoIncluirController@index');
        /* Página de alteração dos produtos */
        $this->addGet('/produtos/alterar/([0-9]+)',   Router::NAMESPACE_CONTROLLER . 'ProdutoAlterarController@index');
        /* Página dos produtos desativados */
        $this->addGet('/produtos/lixeira',            Router::NAMESPACE_CONTROLLER . 'ProdutoLixeiraController@index');
        /* Desativa registro de produto */
        $this->addGet('/produtos/desativar/([0-9]+)', Router::NAMESPACE_CONTROLLER . 'ProdutoDesativarController@desativar');
        /* Ativa registro de produto */
        $this->addGet('/produtos/ativar/([0-9]+)',    Router::NAMESPACE_CONTROLLER . 'ProdutoAtivarController@ativar');
        /* Consulta de vendas */
        $this->addGet('/vendas',                      Router::NAMESPACE_CONTROLLER . 'VendaController@index');
        
        /* Cadastra um novo produto */
        $this->addPost('/produtos/cadastrar',        Router::NAMESPACE_CONTROLLER . 'ProdutoIncluirController@cadastrar');
        /* Altera um produto */
        $this->addPost('/produtos/alterar/([0-9]+)', Router::NAMESPACE_CONTROLLER . 'ProdutoAlterarController@alterar');
        /* Cadastra uma nova venda */
        $this->addPost('/vendas/cadastrar',          Router::NAMESPACE_CONTROLLER . 'VendaIncluirController@cadastrar');        
    }

    /**
     * Adiciona uma rota "GET"
     * @param string $uri
     * @param mixed $Controller
     * @return void
     */
    public function addGet(string $uri, string $Controller): void {
        $this->rotas['GET'][] = ['uri' => $uri, 'Controller' => $Controller];
    }

    /**
     * Adiciona uma rota "POST""
     * @param string $uri
     * @param string $Controller
     * @return void
     */
    public function addPost(string $uri, string $Controller): void {
        $this->rotas['POST'][] = ['uri' => $uri, 'Controller' => $Controller];
    }

    /**
     * Direciona a requisição do usuário para o Controller respectivo
     * @param string $uri
     * @param string $requestType
     * @return string
     */
    public function direciona(string $uri, string $requestType) {
        foreach ($this->rotas[$requestType] as $route) {
            if (preg_match('#^' . $route['uri'] . '$#', $uri, $matches)) {
                array_shift($matches);
                $response = $this->executarAcao($route['Controller'], $matches);
                return $response;
            }
        }
        $response = $this->executarAcao(self::NAMESPACE_CONTROLLER . 'ErrorController@index');
        return $response;
    }

    /**
     * Executa a ação do controller informando os parâmetros presentes na uri
     * @param mixed $Controller
     * @param mixed $params
     * @return mixed
     */
    protected function executarAcao($Controller, $params = []) {
        $Controller = explode('@', $Controller);
        $class      = $Controller[0];
        $metodo     = $Controller[1];

        $ControllerInstance = new $class();
        return call_user_func_array([$ControllerInstance, $metodo], $params);
    }

    /**
     * Redireciona o usuário para a rota informada
     * @param string $uri
     * @return void
     */
    public static function redireciona(string $uri): void {
        ob_start();
        header("Location: $uri");
        die();
        ob_end_flush();
    }
}
