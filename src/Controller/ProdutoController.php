<?php

namespace App\Controller;

use App\Model\Enum\ProdutoEnum;
use App\Model\ProdutoModel;
use App\View\ProdutoView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoController extends BaseController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->View  = new ProdutoView();
        $this->Model = new ProdutoModel();
    }

    /**
     * @inheritDoc
     * @return ProdutoModel
     */
    public function getModel(): \App\Interfaces\Model\ModelInterface {
        return parent::getModel();
    }

    /**
     * @inheritDoc
     * @return ProdutoView
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
        $registros = $this->getModel()->getAll($this->getModel()->getSqlForConsulta(), 'PROativo = ' . ProdutoEnum::ATIVO);
        foreach ($registros as $Produto) {
            $retorno .= $this->getView()->montaLinhaConsulta($Produto->getCodigo(), $Produto->getDescricao(), $Produto->getValorUnitario(), $Produto->getEstoque(), $Produto->getDataUltimaVenda(), $Produto->getTotalVendas());
        }

        if (empty($retorno)) {
            $retorno = 'Não há registros cadastrados no sistema.';
        }

        return $retorno;
    }

    /**
     * Realiza a validação dos campos, disparando um "alert" caso algum campo não esteja preenchido
     * @return boolean
     */
    protected function validaCamposObrigatorios(): bool {
        $retorno = true;
        $camposSemValor = [];
        foreach ($this->getCamposObrigatorios() as $campo => $nomeApresentacao) {
            if (isset($_POST[$campo])) {
                if (empty($_POST[$campo])) {
                    $camposSemValor[] = $nomeApresentacao;
                }
            } else {
                $camposSemValor[] = $nomeApresentacao;
            }
        }
        if (count($camposSemValor)) {
            $retorno = false;
            $this->getView()->mensagem('O(s) campo(s): ' . implode(', ', $camposSemValor) . ' devem ser preenchidos.');
        }

        return $retorno;
    }

    /**
     * Retorna os campos obrigatórios para o procedimento de cadastro
     * @return array
     */
    protected function getCamposObrigatorios(): array {
        return [
            'descricao'     => 'Descrição',
            'estoque'       => 'Estoque',
            'codigoBarras'  => 'Código Barras',
            'valorUnitario' => 'Valor Unitário'
        ];
    }

    /**
     * Retorna o Model preenchido com as informações presentes nos parâmetros
     * @return \App\Model\ProdutoModel
     */
    protected function getModelCarregadoByParametros(): ProdutoModel {
        $Model = new ProdutoModel(
            null,
            $_POST['codigoBarras'],
            $_POST['descricao'],
            $_POST['valorUnitario'],
            $_POST['estoque']
        );

        return $Model;
    }
}
