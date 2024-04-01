<?php

namespace App\Controller;

use App\Model\VendaModel;
use App\View\ProdutoIncluirView;
use App\View\VendaView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class VendaIncluirController extends VendaController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->View  = new VendaView();
        $this->Model = new VendaModel();
    }

    /**
     * @inheritDoc
     * @return VendaView
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
    }

    /**
     * Processa o cadastro de uma nova venda
     * @return string
     */
    public function cadastrar() {
        $sucesso = false;
        if (!empty($_POST)) {
            if ($this->validaCamposObrigatorios()) {
                $sucesso  = $this->insere();
                $mensagem = $sucesso ? 'Registro inserido com sucesso!' : 'Não foi possível cadastrar o registro.';
                $this->getView()->mensagem($mensagem);
            }
        }


        return $this->index();
    }

    /**
     * Realiza a validação dos campos, disparando um "alert" caso algum campo não esteja preenchido
     * @return boolean
     */
    private function validaCamposObrigatorios(): bool {
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
     * Realiza a inserção do registro carregado
     * @return bool
     */
    private function insere(): bool {
        $Model = $this->getModelCarregadoByParametros();
        return $Model->create();
    }


    /**
     * Retorna o Model preenchido com as informações presentes nos parâmetros
     * @return \App\Model\VendaModel
     */
    protected function getModelCarregadoByParametros(): VendaModel {
        $Model = new VendaModel(
            null,
            $_POST['codigoBarras'],
            $_POST['descricao'],
            $_POST['valorUnitario'],
            $_POST['estoque']
        );

        return $Model;
    }
}
