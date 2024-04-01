<?php

namespace App\Controller;

use App\Interfaces\Controller\ControllerInterface;
use App\Interfaces\Model\ModelInterface;
use App\Interfaces\View\ViewInterface;
use App\View\BaseView;

/**
 * Classe base para a criação de controllers
 */
abstract class BaseController implements ControllerInterface {

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

    /**
     * Retorna o Model vinculado ao controller
     * @return \App\Interfaces\Model\ModelInterface
     */
    public function getModel(): ModelInterface {
        return $this->Model;
    }
    /**
     * Retorna a View vinculada ao controller
     * @return \App\Interfaces\View\ViewInterface
     */
    public function getView(): ViewInterface {
        return $this->View;
    }
}
