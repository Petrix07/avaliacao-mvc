<?php

namespace App\Controller;

use App\Interfaces\Model\ModelInterface;
use App\Model\Enum\ProdutoEnum;
use App\Model\ProdutoModel;
use App\Model\VendaModel;
use App\View\VendaView;

/**
 * Controller da entidade de venda
 */
class VendaController extends BaseController {

    /**
     * Construtor da classe
     */
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
     * Retorna o Model vinculado ao controller
     * @return VendaModel
     */
    public function getModel(): ModelInterface {
        return parent::getModel();
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

    /**
     * Retorna as opções de produto
     * @return string
     */
    private function getOpcoesProduto() {
        $itens = '<option disabled selected value=""> Selecionar... </option>';
        $retorno = (new ProdutoModel)->getAll('', 'PROestoque > 0 AND PROativo = ' . ProdutoEnum::ATIVO);
        foreach ($retorno as $Produto) {
            $itens .= $this->getView()->montaItemProduto($Produto->getCodigo(), $Produto->getDescricao());
        }

        return $itens;
    }
}
