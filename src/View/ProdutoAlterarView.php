<?php

namespace App\View;

class ProdutoAlterarView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('form-produto-edit.html', $this->parametrosView);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getParametrosObrigatorios(): array {
        return [];
    }
}
