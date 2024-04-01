<?php

namespace App\Interfaces\Controller;


/**
 * Interface responsável por estabelecer os métodos obrigatórios para as entidades controllers
 */
interface ControllerInterface {

    /**
     * Retorna a página inicial da entidade
     * @return string
     */
    public function index(): string;

    /**
     * Carrega os parâmetros utilizados pela view 
     * @return string
     */
    public function carregaParametrosView(): void;

}
