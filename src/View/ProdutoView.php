<?php

namespace App\View;

class ProdutoView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('produtos.html', $this->parametrosView);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getParametrosObrigatorios(): array {
        return [
            'REGISTROS' => null
        ];
    }

    /**
     * Monta o elemento HTML utilizado para apresentar na consulta
     * @param int $codigo
     * @param string $descricao
     * @param float $valorUnitario
     * @param int $estoque
     * @param string $dataUltimaVenda
     * @param float $valorTotalVendas
     * @return string
     */
    public function montaLinhaConsulta(int $codigo, string $descricao, float $valorUnitario, int $estoque, $dataUltimaVenda = '', $valorTotalVendas = 0): string {
        return '<tr>'
            . '<td><span class="text-muted">' . $codigo . '</span></td>'
            . "<td>{$descricao}</td>"
            . "<td>R$ $valorUnitario</td>"
            . "<td>$estoque</td>"
            . "<td>$dataUltimaVenda</td>"
            . "<td> $valorTotalVendas</td>"
            . "<td>"
            . '<a class="icon" href="/produtos/alterar/' . $codigo . '">'
            . '    <i class="fe fe-edit"></i>'
            . "</a>"
            . "</td>"
            . "<td>"
            . '<a class="icon" href="/produtos/desativar/' . $codigo . '">'
            . '    <i class="fe fe-trash"></i>'
            . "</a>"
            . "</td>"
            . "</tr>";
    }
}
