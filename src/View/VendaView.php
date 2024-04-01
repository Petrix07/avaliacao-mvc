<?php

namespace App\View;

class VendaView extends BaseView {

    /**
     * @inheritDoc
     */
    public function renderizar(): string {
        return $this->getConteudoPaginaHtml('form-venda.html', $this->parametrosView);
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
    public function montaLinhaConsulta(int $codigo, string $descricaoProduto, int $quantidade, float $valorUnitario, float $totalVenda): string {
        return '<td><span class="text-muted">' . $codigo . '</span></td>'
            . '<td>' . $descricaoProduto . '</td>'
            . '<td>' . $quantidade . '</td>'
            . '<td>' . $valorUnitario . '</td>'
            . '<td>R$ ' . $totalVenda . '</td>'
            . '</tr>';
    }

    /**
     * Retorna o item da lista com os dados do produto
     * @param int $codigo
     * @param string $descricao
     * @return string
     */
    public function montaItemProduto(int $codigo, string $descricao) {
        return '<option value="' . $codigo . '">' . $descricao . '</option>';
    }
}
