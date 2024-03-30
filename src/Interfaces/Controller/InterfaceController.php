<?php

namespace App\Interfaces\Controller;

/**
 * INterface responsável por estabelecer os métodos obrigatórios para as entidades controllers
 */
interface InterfaceController {

    /**
     * Retorna a página inicial da entidade
     * @return string
     */
    public function index(): string;

}