<?php
include_once 'index.php';
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        if (array_key_exists("id_pessoa", $params)){
            $user = pessoaHandler::getPessoaById($params['id_pessoa']);
            if ($user){
                echo json_encode([
                   'success' => true,
                   'pessoa' => $user,
                ], true);
                return;
            } else{

                echo json_encode([
                    'success' => false,
                    'message' => "Pessoa não encontrada",
                ], true);
                return;
            }
        }

        if (array_key_exists("id_usuario", $params)){
            $user = usuarioHandler::getUsuarioById($params['id_usuario']);
            $user = pessoaHandler::getPessoaByUsuario($user);
            if ($user){
                echo json_encode([
                    'success' => true,
                    'pessoa' => $user,
                ], true);
                return;
            } else{

                echo json_encode([
                    'success' => false,
                    'message' => "Pessoa não encontrada",
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
