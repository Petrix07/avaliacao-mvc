<?php

namespace App\Controller;

use App\Interfaces\Controller\InterfaceController;
use App\View\BaseView;

/**
 * Classe base para a criação de controllers
 */
abstract class BaseController implements InterfaceController {

    /**
     * Objeto utilizado para a manipulação de registros
     * @var 
     */
    protected $Model;

    /**
     * Objeto utilizado para renderizar as telas apresentadas ao usuário
     * @var BaseView
     */
    protected $View;

}
