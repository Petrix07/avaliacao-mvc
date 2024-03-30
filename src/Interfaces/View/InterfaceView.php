<?php

namespace App\Interfaces\View;

/**
 * INterface responsável por estabelecer os métodos obrigatórios para as entidades controllers
 */
interface InterfaceView {

    /**
     * Retorna a página inicial da entidade
     * @return string
     */
    public function renderizar(): string;

}