<?php

namespace App\Controller;

use App\Core\Router;


/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoAtivarController extends ProdutoController {

    public function ativar(...$id) {
        $sucesso = false;
        if (!empty($id)) {
            $sucesso  = $this->ativa($id);
            if ($sucesso) {
                Router::redireciona('/produtos/lixeira');
            } else {
                $this->getView()->mensagem('Não foi possível remover o registro.');
            }
        }
    }

    /**
     * Realiza a exclusão do registro carregado
     * @return bool
     */
    private function ativa($id): bool {
        return $this->getModel()->setCodigo(current($id))->active();
    }
}
