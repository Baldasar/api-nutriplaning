<?php
include_once "Usuario.php";
include_once "usuarioHandler.php";
include_once "pessoaHandler.php";
include_once "Pessoa.php";

if ($_POST){
    $usuario = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
    ];

    $pessoa = [
        'nome' => $_POST['nome'],
        'altura' => $_POST['altura'],
        'peso' => $_POST['peso'],
        'genero' => $_POST['genero'],
        'idade' => $_POST['idade'],
        'atividade_fisica' => $_POST['atividade'],
    ];

    $usuario = new Usuario($usuario);
    $pessoa['usuario'] = usuarioHandler::createUsuario($usuario);

    $pessoa = new Pessoa($pessoa);
    pessoaHandler::createPessoa($pessoa);
}

?>
<div class="content-body">
    <h1>Registrar</h1>
<form action="/registrar-usuario" method="post">
    <label>Nome Completo</label>
    <input type="name" name="nome" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Senha</label>
    <input type="password" name="senha" required>

    <label>Altura<span class="weak-text"> cm</span></label>
    <input type="number" name="altura" required>

    <label>Peso<span class="weak-text"> kg</span></label>
    <input type="number" name="peso" required>

    <label>Idade<span class="weak-text"> anos</span></label>
    <input type="number" name="idade" required>

    <label>Calcular Como:</label>
    <select name="genero" required>
        <option value="m">Masculino</option>
        <option value="f">Feminino</option>
    </select>

    <label>Nível de Atividade Física</label>
    <select name="atividade" required>
        <option value="1.2">Sedentário</option>
        <option value="1.375">Pouco Ativo</option>
        <option value="1.55">Moderadamente Ativo</option>
        <option value="1.725">Muito Ativo</option>
        <option value="1.9">Extremamente Ativo</option>
    </select>

    <input type="submit" value="Enviar">
</form>
</div>