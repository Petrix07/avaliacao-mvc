<?php

namespace App\View;

class ProdutoIncluirView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('form-produto.html', $this->parametrosView);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getParametrosObrigatorios(): array {
        return [ ];
    }
}
