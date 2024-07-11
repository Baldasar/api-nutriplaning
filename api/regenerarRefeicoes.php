<?php
include_once "index.php";
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        $results = $currentPessoa->toArray();
        $base = 0;
        if ($results['genero'] == "m") {
            $base = 66 + (13.7 * $results['peso']) + (5 * $results['altura']) - (6.8 * $results['idade']);
        }

        if ($results['genero'] == "f") {
            $base = 655 + (9.6 * $results['peso']) + (1.8 * $results['altura']) - (4.7 * $results['idade']);
        }

        $baseAtividade = $base * $results['atividade_fisica'];
        $macrosNecessarios = [];
        foreach (nutricaoCalculatorHelper::getMacroPorcentagem() as $label => $porcentagem) {
            $macrosNecessarios[$label] = nutricaoCalculatorHelper::converteMacronutriente($label, $baseAtividade);
        }
        $iterations = 500;
        if( array_key_exists("debug", $params)){
            $iterations = 100;
        }

        $refeicoes = [];
        foreach ($params['refeicoes'] as $refeicao) {
            $porcentagem = $refeicao['porcentagem'];
            $alimentos = [];
            foreach ($refeicao['alimentos'] as $alimento => $quantidade){
                $alimentoObject = alimentoHandler::getAlimentoById($alimento);
                alimentoHandler::atualizaIndiceCompatibilidade($alimento, 0.05, $currentPessoa->getId());
                $alimentoObject->setQuantidade($quantidade);
                $alimentos[] = $alimentoObject;
            }
            $refeicao = new Refeicao();
            $refeicao->setAlimentos($alimentos);
            $refeicoes[] = nutricaoCalculatorHelper::geraRefeicao($currentPessoa, $macrosNecessarios, (float)$porcentagem / 100, $iterations, $refeicao);
        }

        $package = [
            'success' => true,
            'base' => $base,
            'base_atividade' => $baseAtividade,
            'macros_necessarios' => $macrosNecessarios,
            'resultados' => $results,
            'refeicoes' => $refeicoes,
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

