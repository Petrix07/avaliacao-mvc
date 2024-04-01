<?php

namespace App\Controller;

use App\Model\Enum\ProdutoEnum;
use App\View\ProdutoIncluirView;
use App\View\ProdutoLixeiraView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoLixeiraController extends ProdutoController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        parent::__construct();
        $this->View = new ProdutoLixeiraView();
    }

    /**
     * @inheritDoc
     * @return ProdutoLixeiraView
     */
    public function getView(): \App\Interfaces\View\ViewInterface {
        return parent::getView();
    }

    /**
     * @inheritDoc
     */
    public function index(): string {
        $this->carregaParametrosView();
        return $this->getView()->renderizar();
    }
    /**
     * @inheritDoc
     */
    public function carregaParametrosView(): void {
        $parametros = $this->getView()->getParametrosObrigatorios();
        $parametros['REGISTROS'] = $this->getRegistrosConsulta();

        $this->View->setParametrosView($parametros);
    }

    /**
     * Retorna o HTML contendo os dados dos registros que devem ser inseridos
     * @return string
     */
    private function getRegistrosConsulta() {
        $retorno   = '';
        $registros = $this->getModel()->getAll('', 'PROativo = ' . ProdutoEnum::DESATIVADO);
        foreach ($registros as $Produto) {
            $retorno .= $this->getView()->montaLinhaConsulta($Produto->getCodigo(), $Produto->getDescricao(), $Produto->getValorUnitario(), $Produto->getEstoque());
        }

        if (empty($retorno)) {
            $retorno = 'Não há registros cadastrados no sistema.';
        }

        return $retorno;
    }
}
