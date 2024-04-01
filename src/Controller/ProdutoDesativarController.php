<?php

namespace App\Controller;

use App\Core\Router;


/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class ProdutoDesativarController extends ProdutoController {

    public function desativar(...$id) {
        $sucesso = false;
        if (!empty($id)) {
            $sucesso  = $this->desativa($id);
            if ($sucesso) {
                Router::redireciona('/produtos');
            } else {
                $this->getView()->mensagem('Não foi possível remover o registro.');
            }
        }
    }

    /**
     * Realiza a exclusão do registro carregado
     * @return bool
     */
    private function desativa($id): bool {
        return $this->getModel()->setCodigo(current($id))->disable();
    }
}
