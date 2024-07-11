<?php
include_once 'index.php';
try {
    $params = json_decode(file_get_contents('php://input'), true);
    session_destroy();

    echo json_encode([
        'success' => true,
        'message' => "Deslogado com sucesso!"
    ]);

}catch (Exception $exception){
    $message = "Ocorreu um erro, tente novamente mais tarde!";
    if (isset($params['debug'])){
        $message = $exception;
    }

    echo json_encode([
        'success' => false,
        'message' => $message,
    ], true);
}

?>
