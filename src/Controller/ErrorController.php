<?php

namespace App\Controller;

class ErrorController extends BaseController {

    /**
     * @inheritDoc
     */
    public function index(): string {
        return 'A página solicitada não foi encontrada.';
    }

    /**
     * @inheritDoc
     */
    public function carregaParametrosView(): void {
    }
}
