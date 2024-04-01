<?php

namespace App\Model;


/**
 * Modelo de Produto
 */
class VendaModel extends BaseModel {

    /**
     * @var int
     */
    private $codigo;

    /**
     * @var ProdutoModel
     */
    private $Produto;

    /**
     * @var int
     */
    private $quantidade;

    /**
     * @var float
     */
    private $valorUnitario;

    /**
     * @var float
     */
    private $valorTotal;

    /**
     * Construtor da classe
     * @param int $codigo
     * @param int $codigoProduto
     * @param int $quantidade
     * @param float $valorUnitario
     * @param float $valorTotal
     */
    public function __construct(int $codigo = null, int $codigoProduto = null, int $quantidade = null, float $valorUnitario = null, float $valorTotal = null) {
        $this->Produto = new ProdutoModel();
        $this->codigo        = $codigo;
        $this->Produto->setCodigo($codigoProduto);
        $this->quantidade    = $quantidade;
        $this->valorUnitario = $valorUnitario;
        $this->valorTotal    = $valorTotal;
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
        return 'TBVenda';
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
            $oModel = new VendaModel(
                $registro['VENcodigo'],
                $registro['PROcodigo'],
                $registro['VENquantidade'],
                $registro['VENvalor_unitario'],
                $registro['VENvalor_total']
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
            ['PROcodigo', 'VENquantidade', 'VENvalor_unitario', 'VENvalor_total'],
            [$this->Produto->getCodigo(), $this->quantidade, $this->valorUnitario, $this->valorTotal]
        );
        return $this->execute($sql);
    }

    /**
     * @todo - Desenvolver funcionalidade quando houver atualização da interface gráfica
     * @inheritDoc
     */
    public function refresh(): bool {
        return false;
    }

    /**
     * @todo - Desenvolver funcionalidade quando houver atualização da interface gráfica
     * @inheritDoc
     */
    public function update(): bool {
        return false;
    }

    /**
     * @todo - Desenvolver funcionalidade quando houver atualização da interface gráfica
     * @inheritDoc
     */
    public function remove(): bool {
        return false;
    }

    /**
     * Retorna o valor de de quantidade
     *
     * @return int
     */
    public function getQuantidade() {
        return $this->quantidade;
    }

    /**
     * Seta o valor de quantidade
     *
     * @param int  $quantidade
     *
     * @return self
     */
    public function setQuantidade(int $quantidade) {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Retorna o Produto vinculado
     *
     * @return ProdutoModel
     */
    public function getProduto() {
        return $this->Produto;
    }

    /**
     * Define o produto vinculado a entidade
     *
     * @param int  $codigoProduto
     *
     * @return self
     */
    public function setProduto(ProdutoModel $Produto) {
        $this->Produto = $Produto;

        return $this;
    }

    /**
     * Retorna o valor de de codigo
     *
     * @return int
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Seta o valor de codigo
     *
     * @param int  $codigo
     *
     * @return self
     */
    public function setCodigo(int $codigo) {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Retorna o valor de de valorTotal
     *
     * @return float
     */
    public function getValorTotal() {
        return $this->valorTotal;
    }

    /**
     * Seta o valor de valorTotal
     *
     * @param float  $valorTotal
     *
     * @return self
     */
    public function setValorTotal(float $valorTotal) {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Retorna o valor de valorUnitario
     *
     * @return float
     */
    public function getValorUnitario() {
        return $this->valorUnitario;
    }

    /**
     * Seta o valor de valorUnitario
     *
     * @param float  $valorUnitario
     *
     * @return self
     */
    public function setValorUnitario(float $valorUnitario) {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }
}
