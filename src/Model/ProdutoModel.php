<?php

namespace App\Model;

use App\Model\Enum\ProdutoEnum;

/**
 * Modelo de Produto
 */
class ProdutoModel extends BaseModel {

    /**
     * @var int
     */
    private $codigo;

    /**
     * @var string
     */
    private $codigoBarras;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var float
     */
    private $valorUnitario;

    /**
     * @var int
     */
    private $estoque;

    /**
     * @var string
     */
    private $dataUltimaVenda;

    /**
     * @var int
     */
    private $totalVendas;

    /**
     * @var int
     */
    private $ativo;

    /**
     * Construtor da classe
     * @param int $codigo
     * @param string $descricao
     * @param float $valorUnitario
     * @param int $estoque
     * @param string $dataUltimaVenda
     */
    public function __construct(int $codigo = null, string $codigoBarras = null, string $descricao = null, float $valorUnitario = null, int $estoque = null, string $dataUltimaVenda = null, float $totalVendas = null, int $ativo = null) {
        $this->codigo          = $codigo;
        $this->codigoBarras    = $codigoBarras;
        $this->descricao       = $descricao;
        $this->valorUnitario   = $valorUnitario;
        $this->estoque         = $estoque;
        $this->dataUltimaVenda = $dataUltimaVenda;
        $this->totalVendas     = $totalVendas;
        $this->ativo           = $ativo;
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): string {
        return 'PROJETOMVC';
    }

    /**
     * @inheritDoc
     */
    public function getNomeTabela(): string {
        return 'TBProduto';
    }

    /**
     * @inheritDoc
     */
    public function getAll($sql = '', $condicao = ''): array {
        $retorno = [];
        if (empty($sql))
            $sql = $this->getAllSql();
        if (!empty($condicao))
            $sql .= ' WHERE ' . $condicao;
        $this->getConexao()->setConexao();
        $this->getConexao()->Query($sql);
        $registros = $this->getConexao()->getArrayResults();

        foreach ($registros as $registro) {
            $oModel = new ProdutoModel(
                $registro['PROcodigo'],
                $registro['PROcodigo_barras'],
                $registro['PROdescricao'],
                $registro['PROvalor_unitario'],
                $registro['PROestoque'],
                $registro['PROdata_ultima_venda'],
                null,
                $registro['PROativo']
            );

            $retorno[] = $oModel;
        }
        $this->getConexao()->closeConexao();

        return $retorno;
    }

    /**
     * @inheritDoc
     */
    public function create(): bool {
        $sql = $this->getSqlInsert(
            ['PROdescricao', 'PROcodigo_barras', 'PROestoque', 'PROvalor_unitario'],
            ["'" . $this->descricao . "'", $this->codigoBarras, $this->estoque, $this->valorUnitario]
        );
        return $this->execute($sql);
    }

    /**
     * @inheritDoc
     */
    public function refresh(): bool {
        $sql  = $this->getAllSql();
        $sql .= ' WHERE PROcodigo = ' . $this->codigo . ' LIMIT 1';
        $this->getConexao()->setConexao();
        $this->getConexao()->Query($sql);
        $registros = $this->getConexao()->getArrayResults();

        foreach ($registros as $registro) {
            $this->setCodigo($registro['PROcodigo']);
            $this->setCodigoBarras($registro['PROcodigo_barras']);
            $this->setDescricao($registro['PROdescricao']);
            $this->setValorUnitario($registro['PROvalor_unitario']);
            $this->setEstoque($registro['PROestoque']);
            $this->setDataUltimaVenda($registro['PROdata_ultima_venda']);
            $this->setAtivo($registro['PROativo']);
        }

        $this->getConexao()->closeConexao();

        return count($registros) > 0;
    }

    /**
     * @inheritDoc
     */
    public function update(): bool {
        $sql  = $this->getSqlUpdate(
            [
                'PROcodigo_barras'  => $this->codigoBarras,
                'PROdescricao'      => "'$this->descricao'",
                'PROvalor_unitario' => $this->valorUnitario,
                'PROestoque'        => $this->estoque
            ]
        );

        $sql .= ' WHERE PROcodigo = ' . $this->codigo;

        $this->getConexao()->setConexao();
        $retorno = $this->getConexao()->Query($sql, true);
        $this->getConexao()->closeConexao();

        return $retorno;
    }

    /**
     * @inheritDoc
     */
    public function active(): bool {
        $sql  = $this->getSqlUpdate(['PROativo'  => ProdutoEnum::ATIVO]);

        $sql .= ' WHERE PROcodigo = ' . $this->codigo;

        $this->getConexao()->setConexao();
        $retorno = $this->getConexao()->Query($sql, true);
        $this->getConexao()->closeConexao();

        return $retorno;
    }
    /**
     * @inheritDoc
     */
    public function disable(): bool {
        $sql  = $this->getSqlUpdate(['PROativo'  => ProdutoEnum::DESATIVADO]);

        $sql .= ' WHERE PROcodigo = ' . $this->codigo;

        $this->getConexao()->setConexao();
        $retorno = $this->getConexao()->Query($sql, true);
        $this->getConexao()->closeConexao();

        return $retorno;
    }

    /**
     * @inheritDoc
     */
    public function remove(): bool {
        $sql  = $this->getSqlDelete(['PROcodigo'  => $this->codigo]);

        $this->getConexao()->setConexao();
        $retorno = $this->getConexao()->Query($sql, true);
        $this->getConexao()->closeConexao();

        return $retorno;
    }

    /**
     * Retorna o valor de de codigo
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Seta o valor de codigo
     *
     * @return  self
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Retorna o valor de de descricao
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Seta o valor de descricao
     *
     * @return  self
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Retorna o valor de de valorUnitario
     */
    public function getValorUnitario() {
        return $this->valorUnitario;
    }

    /**
     * Seta o valor de valorUnitario
     *
     * @return  self
     */
    public function setValorUnitario($valorUnitario) {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Retorna o valor de de estoque
     */
    public function getEstoque() {
        return $this->estoque;
    }

    /**
     * Seta o valor de estoque
     *
     * @return  self
     */
    public function setEstoque($estoque) {
        $this->estoque = $estoque;

        return $this;
    }

    /**
     * Retorna o valor de dataUltimaVenda
     */
    public function getDataUltimaVenda() {
        return $this->dataUltimaVenda;
    }

    /**
     * Seta o valor de dataUltimaVenda
     *
     * @return  self
     */
    public function setDataUltimaVenda($dataUltimaVenda) {
        $this->dataUltimaVenda = $dataUltimaVenda;

        return $this;
    }

    /**
     * Retorna o valor totalVendas
     */
    public function getTotalVendas() {
        return $this->totalVendas;
    }

    /**
     * Seta o valor de totalVendas
     *
     * @return  self
     */
    public function setTotalVendas($totalVendas) {
        $this->totalVendas = $totalVendas;

        return $this;
    }

    /**
     * Retorna o valor de codigoBarras
     *
     * @return  string
     */
    public function getCodigoBarras() {
        return $this->codigoBarras;
    }

    /**
     * Set de codigoBarras
     *
     * @param  string  $codigoBarras
     *
     * @return  self
     */
    public function setCodigoBarras(string $codigoBarras) {
        $this->codigoBarras = $codigoBarras;

        return $this;
    }

    /**
     * Retorna o valor de ativo
     *
     * @return  int
     */
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * Define ativo
     *
     * @param  int  $ativo
     *
     * @return  self
     */
    public function setAtivo(int $ativo) {
        $this->ativo = $ativo;

        return $this;
    }
}
