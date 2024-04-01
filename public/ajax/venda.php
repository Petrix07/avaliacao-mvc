<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Model\ProdutoModel;

class VendaAjax {
    public function processarDados() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if ($data) {
                $codigoProduto = $data['codigoProduto'];
                $Model = new ProdutoModel($codigoProduto);
                $Model->refresh();
                echo json_encode(['status' => 'success', 'valorUnitario' => $Model->getValorUnitario(), 'quantidade' => $Model->getEstoque()]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Dados não recebidos']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido']);
        }
    }
}

// Instancia a classe e chama o método para processar os dados recebidos via AJAX
$controller = new VendaAjax();
$controller->processarDados();
