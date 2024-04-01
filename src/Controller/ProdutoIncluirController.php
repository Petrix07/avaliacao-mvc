<?php

namespace App\Controller;

use App\View\ProdutoIncluirView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoIncluirController extends ProdutoController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        parent::__construct();
        $this->View  = new ProdutoIncluirView();
    }

    /**
     * @inheritDoc
     * @return ProdutoIncluirView
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
     * Processa o cadastro de um novo registro
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
     * Realiza a inserção do registro carregado
     * @return bool
     */
    private function insere(): bool {
        $Model = $this->getModelCarregadoByParametros();
        return $Model->create();
    }
}
