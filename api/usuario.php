<?php
include_once 'index.php';
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        if (array_key_exists('id', $params)){
            $user = usuarioHandler::getUsuarioById($params['id']);
            if ($user){
                echo json_encode([
                   'success' => true,
                   'usuario' => $user,
                ], true);
                return;
            } else{
                echo json_encode([
                    'success' => false,
                    'message' => "Usuário não encontrado",
                ], true);
                return;
            }
        }
    }
}
catch (\Exception $exception){
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
