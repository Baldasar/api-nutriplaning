<?php
include_once "nutricaoCalculatorHelper.php";
include_once "Refeicao.php";
include_once "pessoaHandler.php";

    if ($_POST):
        $results = $currentPessoa->toArray();
        $results['porcentagem'] = $_POST['porcentagem'];
        $base = 0;
        if ($results['genero'] == "m"){
            $base = 66 + (13.7 * $results['peso']) + (5 * $results['altura']) - (6.8 * $results['idade']);
        }

        if ($results['genero'] == "f"){
            $base = 655 + (9.6 * $results['peso']) + (1.8 * $results['altura']) - (4.7 * $results['idade']);
        }

        $baseAtividade = $base * $results['atividade_fisica'];
        $macrosNecessarios = [];
        foreach (nutricaoCalculatorHelper::getMacroPorcentagem() as $label => $porcentagem){
            $macrosNecessarios[$label] = nutricaoCalculatorHelper::converteMacronutriente($label, $baseAtividade);
        }

        $refeicoes = [];
        foreach ($results['porcentagem'] as $porcentagem){
            $refeicoes[] = nutricaoCalculatorHelper::geraRefeicao($macrosNecessarios, (float)$porcentagem/100);
        }

        if (isset($_POST['alimentos'])){
            foreach ($_POST['alimentos'] as $alimento){
                alimentoHandler::atualizaIndiceCompatibilidade($alimento, -0.1);
            }
        }
        ini_set('xdebug.var_display_max_depth', 10);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);







    ?>
<div class="content-body">
    <h1>Recomendação de Refeições</h1>

    <form class="alimento" action="/gerar-refeicoes" method="post">
        <h2 >Necessidades Nutricionais:</h2>
        <h3 class="alimento-name">Calorias necessárias:</h3>
        <p>Base: <?= $base ?> Kcal</p>
        <p>Base + Atividade: <?= $baseAtividade ?> Kcal</p><br>

        <h3 class="alimento-name">Macronutrientes necessários:</h3>
        <p>Proteinas: <?= number_format($macrosNecessarios['proteina'], 2) ?>g</p>
        <p>Lipídios: <?= number_format($macrosNecessarios['lipideos'], 2) ?>g</p>
        <p>Carboidratos: <?= number_format($macrosNecessarios['carboidrato'], 2) ?>g</p>
        <br>

        <?php foreach ($results['porcentagem'] as $porcentagem): ?>
            <input type="hidden"value="<?=$porcentagem?>" name="porcentagem[]">
        <?php endforeach; ?>

        <?php foreach ($refeicoes as $key => $refeicao): ?>
        <div class="refeicao">
            <h3><?= $key+1 ?>ª Refeição:</h3>
            <?php foreach ($refeicao->getAlimentos() as $alimento): ?>
            <br>
            <div class="alimento">
                <input type="hidden" value="<?=$alimento->getId()?>" name="alimentos[]">
                <h4 class="alimento-name"><?= $alimento->getDescricaoAlimento() ?>: <?= $alimento->getQuantidade() ?>g</h4>
                <p>Calorias: <?= number_format($alimento->getEnergiaKcal()) ?>Kcal</p>
                <p>Proteinas: <?= number_format($alimento->getMacroNutrientes()['proteina']) ?>g</p>
                <p>Lipídios: <?= number_format($alimento->getMacroNutrientes()['lipideos']) ?>g</p>
                <p>Carboidratos: <?= number_format($alimento->getMacroNutrientes()['carboidrato']) ?>g</p>
            </div>
            <?php endforeach; ?>
        </div>
        <br>
        <?php endforeach; ?>

        <input type="submit" class="gerar-refeicoes" value="Nova Sugestão">
    </form>
</div>

    <?php else: ?>
    <div class="content-body">
        <h1 style="text-align: center">Plano de refeições</h1>

        <form action="/gerar-refeicoes" method="post">
            <input type="button" id="add-refeicao" value="Nova Refeição">
            <div class="refeicao-wrapper">

            </div>

            <input type="submit" class="gerar-refeicoes" value="Gerar Refeições">
        </form>
    </div>
        <script>
            function addRefeicao(){
                const newRefeicao = document.createElement("div");
                newRefeicao.classList.add("refeicao");
                newRefeicao.innerHTML = `
                <h3 style="text-align: center">Proporção Calórica</h3>
                <div style="display: grid;    grid-template-columns: 10fr 4fr; grid-gap: 10px">
                    <input type="range" class="true-value"  min="0" max="100" step="5" value="100" name="porcentagem[]">
                    <input type="text" class="display-value" value="100%" disabled>
                </div>

                <input type="button" class="remove-refeicao" value="Remover">

            `;

                newRefeicao.querySelector(".true-value").addEventListener("change", (e) => {
                    e.currentTarget.closest(".refeicao").querySelector(".display-value").value = e.currentTarget.value + "%";
                })

                document.querySelector(".refeicao-wrapper").appendChild(newRefeicao);
            }

            document.getElementById("add-refeicao").addEventListener("click", () => {
                addRefeicao()
            })

            document.addEventListener("click", (e) => {
                if (e.target.classList.contains("remove-refeicao")){
                    e.target.closest(".refeicao").remove();
                }
            })

            addRefeicao()
        </script>

    <?php endif; ?>
