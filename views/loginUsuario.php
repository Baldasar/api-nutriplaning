<?php
    include_once "usuarioHandler.php";
    include_once "pessoaHandler.php";

    if ($_POST){
        $usuario = usuarioHandler::attemptLogin($_POST['email'], $_POST['senha']);

        if ($usuario){
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['nome'] = $usuario->getNome();
            header("Location: /atualizar-usuario");
        }
    }


?>
<div class="content-body">
    <h1>Login</h1>
    <form action="/login-usuario" method="post">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <a href="/registrar-usuario" style="color: #163316">Criar Conta</a>
        <input type="submit" value="Enviar">
    </form>
</div>
