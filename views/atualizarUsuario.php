<?php
if ($_POST){
    $pessoa = [
        'id' => $_POST['id'],
        'altura' => $_POST['altura'],
        'peso' => $_POST['peso'],
        'genero' => $_POST['genero'],
        'idade' => $_POST['idade'],
        'atividade_fisica' => $_POST['atividade'],
    ];

    $pessoa = new Pessoa($pessoa);
    pessoaHandler::updatePessoa($pessoa);
    header("Location: /atualizar-usuario");
}

?>
<div class="content-body">
    <h1>Atualizar Dados</h1>
    <form action="/atualizar-usuario" method="post">
        <input type="hidden" name="id" value="<?= $currentPessoa->getId(); ?>">

        <label>Altura<span class="weak-text"> cm</span></label>
        <input type="number" name="altura" value="<?= $currentPessoa->getAltura(); ?>" required>

        <label>Peso<span class="weak-text"> kg</span></label>
        <input type="number" name="peso" value="<?= $currentPessoa->getPeso(); ?>" required>

        <label>Idade<span class="weak-text"> anos</span></label>
        <input type="number" name="idade" value="<?= $currentPessoa->getIdade(); ?>" required>

        <label>Calcular Como:</label>
        <select name="genero" required>
            <option <?= ($currentPessoa->getGenero() == "m") ? "selected" : "" ?> value="m">Masculino</option>
            <option <?= ($currentPessoa->getGenero() == "f") ? "selected" : "" ?> value="f">Feminino</option>
        </select>

        <label>Nível de Atividade Física</label>
        <select name="atividade" required>
            <option <?= ($currentPessoa->getAtividadeFisica() == "1.2") ? "selected" : "" ?> value="1.2">Sedentário</option>
            <option <?= ($currentPessoa->getAtividadeFisica() == "1.375") ? "selected" : "" ?> value="1.375">Pouco Ativo</option>
            <option <?= ($currentPessoa->getAtividadeFisica() == "1.55") ? "selected" : "" ?> value="1.55">Moderadamente Ativo</option>
            <option <?= ($currentPessoa->getAtividadeFisica() == "1.725") ? "selected" : "" ?> value="1.725">Muito Ativo</option>
            <option <?= ($currentPessoa->getAtividadeFisica() == "1.9") ? "selected" : "" ?> value="1.9">Extremamente Ativo</option>
        </select>

        <input type="submit" value="Enviar">
    </form>
</div>