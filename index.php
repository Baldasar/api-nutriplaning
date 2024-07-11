<?php
    session_start();

    include_once "dbConnectHandler.php";
    include_once "Usuario.php";
    include_once "usuarioHandler.php";
    include_once "pessoaHandler.php";
    include_once "Pessoa.php";

    $currentUser = null;
    if (isset($_SESSION['id'])){
        $currentUser = $_SESSION['id'];
        $currentUser = usuarioHandler::getUsuarioById($currentUser);
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

?>
<head>
    <title>NutriPlanning</title>
    <link rel="stylesheet" href="assets/css.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <header class="main-header">
        <div class="main-header-item">

        </div>
        <?php if($_SESSION): ?>
        <ul class="main-header-item">
            <a href="/atualizar-usuario">Perfil</a>
            <a href="/gerar-refeicoes">Refeições</a>
            <a href="/logout-usuario">Sair</a>
        </ul>
        <?php else: ?>
        <ul class="main-header-item">
            <a href="/login-usuario">Login</a>
        </ul>
        <?php endif; ?>
    </header>
    <main class="content-wrapper">
        <div class="main-content">
            <?php
            if (isset($_SESSION['id'])){
                include "views/$request.php";
            } else{
                if (in_array($request, $allUsers)){
                    include "views/$request.php";
                } else{
                    header ("Location: login-usuario");
                }
            }

            ?>
        </div>
    </main>
    <footer class="main-footer">
        <footer class="main-footer-item">
            <p>Nutriplanning 👍</p>
        </footer>
    </footer>
</body>
