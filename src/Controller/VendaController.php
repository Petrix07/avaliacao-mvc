<?php

namespace App\Controller;

use App\Model\Enum\ProdutoEnum;
use App\Model\ProdutoModel;
use App\Model\VendaModel;
use App\View\VendaView;

class VendaController extends BaseController {

    public function __construct() {
        $this->View  = new VendaView();
        $this->Model = new VendaModel();
    }

    /**
     * @inheritDoc
     * @return \App\View\VendaView
     */
    public function getView(): \App\Interfaces\View\ViewInterface {
        return parent::getView();
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function index(): string {
        $this->carregaParametrosView();

        return $this->getView()->renderizar();
    }

    public function carregaParametrosView(): void {
        $parametros = $this->getView()->getParametrosObrigatorios();
        $parametros['REGISTROS'] = $this->getRegistrosConsulta();
        $parametros['PRODUTOS']  = $this->getOpcoesProduto();

        $this->View->setParametrosView($parametros);
    }

    /**
     * Retorna o HTML contendo os dados dos registros que devem ser inseridos
     * @return string
     */
    private function getRegistrosConsulta() {
        $retorno   = '';
        $registros = $this->getModel()->getAll();
        foreach ($registros as $Venda) {
            $Venda->getProduto()->refresh();
            if ($Venda->getProduto()->getAtivo() == ProdutoEnum::ATIVO) {
                $retorno .= $this->getView()->montaLinhaConsulta($Venda->getCodigo(), $Venda->getProduto()->getDescricao(), $Venda->getQuantidade(), $Venda->getValorUnitario(), $Venda->getValorTotal());
            }
        }

        if (empty($retorno)) {
            $retorno = 'Não há registros cadastrados no sistema.';
        }

        return $retorno;
    }

    private function getOpcoesProduto() {
        $itens = '';
        $retorno = (new ProdutoModel)->getAll('', 'PROestoque > 0 AND PROativo = ' . ProdutoEnum::ATIVO);
        foreach ($retorno as $Produto) {
            $itens .= $this->getView()->montaItemProduto($Produto->getCodigo(), $Produto->getDescricao());
        }

        return $itens;
    }
}
