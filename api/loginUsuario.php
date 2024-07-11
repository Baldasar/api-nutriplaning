<?php

    $params = json_decode(file_get_contents('php://input'), true);
    if ($params){
        $usuario = usuarioHandler::attemptLogin($params['email'], $params['senha']);

        if ($usuario){
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['nome'] = $usuario->getNome();

            http_response_code(200);
            echo(json_encode([
                'success' => true,
                'id' => $usuario->getId(),
                'nome' => $usuario->getNome(),
                'message' => "Conectado com sucesso!",
            ]));
            return;
        }

        echo json_encode([
            'success' => false,
            'message' => "Usuário ou senha erradas!",
        ]);
        return;
    }
?>
