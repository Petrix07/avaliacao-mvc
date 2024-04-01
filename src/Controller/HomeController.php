<?php

namespace App\Controller;

use App\Model\DataBase\Conexao;
use App\Model\ProdutoModel;
use App\Model\VendaModel;
use App\View\HomeView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class HomeController extends BaseController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->View = new HomeView();
    }

    /**
     * @inheritDoc
     */
    public function index(): string {
        $this->carregaParametrosView();

        return $this->View->renderizar();
    }

    /**
     * @inheritDoc
     * @return void
     */
    public function carregaParametrosView(): void {
        $parametros = $this->View->getParametrosObrigatorios();
        $parametros['QUANTIDADE_PRODUTOS'] = (new ProdutoModel())->getTotalRegistros();
        $parametros['QUANTIDADE_VENDAS']   = (new VendaModel())->getTotalRegistros();;

        $this->View->setParametrosView($parametros);
    }
}
