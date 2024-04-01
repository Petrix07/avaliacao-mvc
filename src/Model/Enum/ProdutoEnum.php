<?php

namespace App\Model\Enum;

/**
 * Classe enum da entidade Produto
 */
abstract class ProdutoEnum {

    const
        ATIVO = 1,
        _ATIVO = 'Ativo',

        DESATIVADO = 0,
        _DESATIVADO = 'Inativo';
}
