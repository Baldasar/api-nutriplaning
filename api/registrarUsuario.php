<?php
include_once 'index.php';
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params){
        $usuario = [
            'nome' => $params['nome'],
            'email' => $params['email'],
            'senha' => $params['senha'],
        ];

        $pessoa = [
            'nome' => $params['nome'],
            'altura' => $params['altura'],
            'peso' => $params['peso'],
            'genero' => $params['genero'],
            'idade' => $params['idade'],
            'atividade_fisica' => $params['atividade'],
            'black_list' => $params['black_list'],
        ];

        $usuario = new Usuario($usuario);
        $pessoa['usuario'] = usuarioHandler::createUsuario($usuario);

        $pessoa = new Pessoa($pessoa);
        pessoaHandler::createPessoa($pessoa);

        echo json_encode([
            'success' => true,
            'message' => "Usuario registrado com sucesso",
        ], true);

    }
} catch (\Exception $exception){
    $message = "Ocorreu um erro, tente novamente mais tarde!";
    if (isset($params['debug'])){
        $message = $exception;
    }

    echo json_encode([
        'success' => false,
        'message' => $message,
    ], true);
}
