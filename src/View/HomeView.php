<?php

namespace App\View;

class HomeView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('index.html', $this->getParametrosPaginaInicial());
    }

    private function getParametrosPaginaInicial(): array {
        return [
            'QUANTIDADE_PRODUTOS' => 5,
            'QUANTIDADE_VENDAS'   => 5
        ];
    }
}
