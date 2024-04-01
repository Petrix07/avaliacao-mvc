<?php

namespace App\Controller;

use App\Core\Router;
use App\Model\ProdutoModel;
use App\View\ProdutoAlterarView;
use App\View\ProdutoView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoAlterarController extends ProdutoController {

    /**
     * Construtor da classe
     */
    public function __construct() {
        parent::__construct();
        $this->View  = new ProdutoAlterarView();
    }

    /**
     * @inheritDoc
     */
    public function index(...$id): string {
        $this->getModel()->setCodigo(current($id));
        $this->getModel()->refresh();
        $this->carregaParametrosView();

        return $this->getView()->renderizar();
    }

    /**
     * @inheritDoc
     */
    public function carregaParametrosView(): void {
        $parametros = $this->View->getParametrosObrigatorios();
        $parametros['CODIGO']         = $this->getModel()->getCodigo();
        $parametros['DESCRICAO']      = $this->getModel()->getDescricao();
        $parametros['ESTOQUE']        = $this->getModel()->getEstoque();
        $parametros['CODIGO_BARRAS']  = $this->getModel()->getCodigoBarras();
        $parametros['VALOR_UNITARIO'] = $this->getModel()->getValorUnitario();

        $this->View->setParametrosView($parametros);
    }

    /**
     * Processa alteração do registro
     * @param array $id
     * @return void
     */
    public function alterar(...$id) {
        $sucesso = false;
        if (!empty($_POST)) {
            if ($this->validaCamposObrigatorios()) {
                $sucesso  = $this->altera($id);
                if ($sucesso) {
                    Router::redireciona('/produtos');
                } else {
                    $this->getView()->mensagem('Não foi possível alterar o registro.');
                }
            }
        }
    }

    /**
     * Realiza a inserção do registro carregado
     * @return bool
     */
    private function altera($id): bool {
        $Model = $this->getModelCarregadoByParametros();
        $Model->setCodigo(current($id));

        return $Model->update();
    }
}
