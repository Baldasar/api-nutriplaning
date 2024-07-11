<?php
include_once "index.php";
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        $refeicoes = [];
        foreach ($params['refeicoes'] as $refeicao) {
            $porcentagem = $refeicao['porcentagem'];
            foreach ($refeicao['alimentos'] as $alimento => $quantidade){
                alimentoHandler::atualizaIndiceCompatibilidade($alimento, 0.1, $currentPessoa->getId());
            }
        }

        $package = [
            'success' => true,
            "message" => "Salvo com sucesso!",
        ];

        http_response_code(200);
        echo (json_encode($package, true));
    }
} catch (\Exception $exception){
    $message = "Ocorreu um erro, tente novamente mais tarde!";
    if (isset($params['debug'])){
        $message = $exception;
    }

    http_response_code(200);
    echo json_encode([
        'success' => false,
        'message' => $message,
    ], true);
}
?>

