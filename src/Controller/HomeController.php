<?php

namespace App\Controller;

use App\View\HomeView;

/**
 * Controller responsável por gerenciar a página inicial do sistema
 */
class HomeController extends BaseController {

    public function __construct() {
        $this->View = new HomeView();
    }

    /**
     * @inheritDoc
     */
    public function index(): string {
        return $this->View->renderizar();
    }

    public function teste() {
        return '123123';
    }
}
