<?php

namespace App\View;

class HomeView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('index.html', $this->parametrosView);
    }

    public function getParametrosObrigatorios(): array {
        return [
            'QUANTIDADE_PRODUTOS' => null,
            'QUANTIDADE_VENDAS'   => null
        ];
    }
}
