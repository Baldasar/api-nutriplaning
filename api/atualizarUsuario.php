<?php
include_once 'index.php';
try {
    $params = json_decode(file_get_contents('php://input'), true);
    if ($params) {
        $usuario = usuarioHandler::getUsuarioById($params['id_usuario']);
        $pessoa = pessoaHandler::getPessoaByUsuario($usuario);
        $pessoa = $pessoa->toArray();

        $pessoa['altura'] = $params['altura'];
        $pessoa['peso'] = $params['peso'];
        $pessoa['genero'] = $params['genero'];
        $pessoa['idade'] = $params['idade'];
        $pessoa['atividade_fisica'] = $params['atividade'];
        $pessoa['black_list'] = $params['black_list'];

        $pessoa = new Pessoa($pessoa);
        pessoaHandler::updatePessoa($pessoa);
        echo json_encode([
            'success' => true,
            'message' => "Usuário atualizado com sucesso",
        ], true);
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
