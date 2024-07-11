<?php
    include_once "../api/headers.php";
    include_once "../dbConnectHandler.php";
    include_once "../Usuario.php";
    include_once "../usuarioHandler.php";
    include_once "../Pessoa.php";
    include_once "../pessoaHandler.php";
    include_once "../nutricaoCalculatorHelper.php";

    $params = json_decode(file_get_contents('php://input'), true);

    $currentUser = null;
    $currentPessoa = null;
    if (isset($params['id_usuario'])){
        $currentUser = usuarioHandler::getUsuarioById($params['id_usuario']);
        $currentPessoa = pessoaHandler::getPessoaByUsuario($currentUser);
    }

    $request = substr($_SERVER['REQUEST_URI'], 1);


    function dashToCamelCase($string, $capitalizeFirstCharacter = false) {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }
    $request = dashToCamelCase($request);

    $allUsers = [
        'loginUsuario',
        'registrarUsuario',
    ];


    include "../$request.php";
?>
