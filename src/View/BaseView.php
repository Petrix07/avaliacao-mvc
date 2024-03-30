<?php

namespace App\View;

use App\Interfaces\View\InterfaceView;

/**
 * Classe base para a criação de views
 */
abstract class BaseView implements InterfaceView {

    const
        PATH_PAGINAS_HTML = __DIR__ . '/../../public/';

    /**
     * Retorna o conteúdo da página HTML solicitada
     *
     * @param string $nomeArquivo
     * @return string
     */
    protected function getConteudoPaginaHtml(string $nomeArquivo, array $parametros): string {
        $path     = self::PATH_PAGINAS_HTML . $nomeArquivo;
        $conteudo = 'não encontrado';

        if (file_exists($path)) {
            $conteudo = file_get_contents($path);
            if (count($parametros)) {
                $conteudo = str_replace($this->getPalavrasChavesSubstituicao($parametros), array_values($parametros), $conteudo);
            }
        }

        return $conteudo;
    }

    /**
     * Retorna um array contendo as palavras chaves que serão buscadas para a substituição
     * @param array $parametros
     * @return array
     */
    private function getPalavrasChavesSubstituicao(array $parametros): array {
        $arrayBase = array_keys($parametros);
        return array_map(function ($palavra) {
            return '{{' . $palavra . '}}';
        }, $arrayBase);
    }
}
