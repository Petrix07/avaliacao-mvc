<?php

namespace App\Interfaces\Model;

interface ModelInterface {

    /**
     * Retorna o schema que a tabela está alocada
     * @return string
     */
    public function getSchema(): string;

    /**
     * Retorna o nome da tabela da entidade
     * @return string
     */
    public function getNomeTabela(): string;

    /**
     * Retorna um array contendo todos os registros da entidade
     * @return array
     */
    public function getAll(): array;

    /**
     * Método responsável pela inserção de um novo registro
     * @return bool
     */
    public function create(): bool;

    /**
     * Persiste o objeto carregando suas informações
     * @return bool
     */
    public function refresh(): bool;

    /**
     * Altera o registro com as informações presentes no modelo
     * @return bool
     */
    public function update(): bool;

    /**
     * Remove o registro com as informações presentes no modelo
     * @return bool
     */
    public function remove(): bool;
}
