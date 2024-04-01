<?php

namespace App\Model;

use App\Interfaces\Model\ModelInterface;
use App\Model\DataBase\Conexao;

/**
 * Classe base para a criação de models
 */
abstract class BaseModel implements ModelInterface {

    /**
     * Entidade de conexão com o banco de dados
     * @var \App\Model\DataBase\Conexao
     */
    protected $Conexao;

    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->Conexao = new Conexao();
    }

    /**
     * Retorna a entidade "Conexao"
     * @return \App\Model\DataBase\Conexao
     */
    public function getConexao(): Conexao {
        isset($this->Conexao) && $this->Conexao instanceof Conexao ?: $this->Conexao = new Conexao();
        return $this->Conexao;
    }

    /**
     * Retorna o nome da tabela com o schema 
     * @return string
     */
    public function getTable(): string {
        return $this->getSchema() . "." . $this->getNomeTabela();
    }

    /**
     * Retorna o total de registros presentes na tabela
     * @return int
     */
    public function getTotalRegistros(): int {
        $retorno = 0;
        $sql     = 'SELECT COUNT(1) as TOTAL FROM ' . $this->getTable();
        $this->getConexao()->setConexao();
        $this->getConexao()->Query($sql);
        $rows = $this->getConexao()->getQuery()->fetch_all(MYSQLI_ASSOC);

        foreach ($rows as $row) {
            if (isset($row['TOTAL'])) {
                $retorno = $row['TOTAL'];
                break;
            }
        }
        $this->getConexao()->closeConexao();

        return $retorno;
    }

    /**
     * Retorna o SQL que consulta todos os registros
     * @param array $colunas
     * @return string
     */
    public function getAllSql(array $colunas = []): string {
        $sql = "SELECT * FROM {$this->getTable()}";
        if (count($colunas)) {
            $sql = str_replace('*', implode(', ', $colunas), $sql);
        }

        return $sql;
    }

    /**
     * Retorna o SQL base para a inserção do registro
     * @return string
     */
    protected function getSqlInsert(array $colunas, array $valores): string {
        $sql = 'INSERT INTO ' . $this->getTable() . '(' . implode(',', $colunas) . ')'
            . ' VALUES ' . '(' . implode(',', $valores) . ')';

        return $sql;
    }


    /**
     * Retorna o SQL base para a alteração do registro
     * @param array $valores
     * @return string
     */
    protected function getSqlUpdate(array $valores): string {
        $colunasAtualizar  = array_map([$this, 'getTextoColunasForSql'], array_keys($valores), $valores);

        return 'UPDATE ' . $this->getTable() . ' SET ' . implode(', ', $colunasAtualizar);
    }

    /**
     * Retorna a concatenação da coluna e do valor para ser utilizado nas querys sql
     * @param mixed $chave
     * @param mixed $valor
     * @return string
     */
    public function getTextoColunasForSql($chave, $valor) {
        return "$chave = $valor";
    }


        /**
     * Retorna o SQL base para a alteração do registro
     * @param array $valores
     * @return string
     */
    protected function getSqlDelete(array $chaves): string {
        $colunasAtualizar  = array_map([$this, 'getTextoColunasForSql'], array_keys($chaves), $chaves);

        return 'DELETE FROM ' . $this->getTable() . ' WHERE ' . implode(' AND ', $colunasAtualizar);
    }
    /**
     * Executa o SQL retornando o booleano 
     * @param string $sql
     * @return bool
     */
    public function execute(string $sql): bool {
        $this->getConexao()->setConexao();
        $retorno = (bool) $this->getConexao()->Query($sql, true);
        $this->getConexao()->closeConexao();

        return $retorno;
    }
}
