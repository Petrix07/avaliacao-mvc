<?php

namespace App\Interfaces\View;

/**
 * INterface responsável por estabelecer os métodos obrigatórios para as entidades controllers
 */
interface ViewInterface {

    /**
     * Retorna a página inicial da entidade
     * @return string
     */
    public function renderizar(): string;

    public function getParametrosObrigatorios(): array;


}
