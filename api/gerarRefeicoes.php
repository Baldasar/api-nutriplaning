<?php
include_once "index.php";
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        $results = $currentPessoa->toArray();
        $results['porcentagem'] =  $params['porcentagem'];

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
        foreach ($results['porcentagem'] as $porcentagem) {
            $refeicoes[] = nutricaoCalculatorHelper::geraRefeicao($currentPessoa, $macrosNecessarios, (float)$porcentagem / 100, $iterations);
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

    http_response_code(200);
    echo json_encode([
        'success' => false,
        'message' => $exception->getMessage(),
    ], true);
}
?>

