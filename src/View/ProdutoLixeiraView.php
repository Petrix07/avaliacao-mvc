<?php

namespace App\View;

class ProdutoLixeiraView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('produtos-excluidos.html', $this->parametrosView);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getParametrosObrigatorios(): array {
        return ['REGISTROS' => null];
    }

    public function montaLinhaConsulta(int $codigo, string $descricao, float $valorUnitario, int $estoque): string {
        return '<tr>'
            . '<td><span class="text-muted">' . $codigo . '</span></td>'
            . "<td>$descricao</td>"
            . "<td>$valorUnitario</td>"
            . "<td>$estoque</td>"
            . '<td>'
            . '<a class="icon" href="/produtos/ativar/' . $codigo . '">'
            . '<i class="fe fe-refresh-ccw"></i>'
            . '</a>'
            . '</td>'
            . '</tr>';
    }
}
