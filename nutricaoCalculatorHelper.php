<?php
include_once "Refeicao.php";
class nutricaoCalculatorHelper
{
    public static function converteMacronutriente($tipo, $valor, $paraGramas = true){
        switch ($tipo){
            case "proteina":
                return self::converteProteina($valor, $paraGramas) * self::getProteinaPorcentagem();
            break;
            case "carboidrato":
                return self::converteCarboidrato($valor, $paraGramas) * self::getCarboidratoPorcentagem();
            break;
            case "lipideos":
                return self::converteLipideos($valor, $paraGramas) * self::getLipideosPorcentagem();
            break;
        }

        return 0;
    }

    public static function converteCarboidrato($valor, $paraGramas = true)
    {
        if ($paraGramas){
            return $valor / 4;
        } else{
            return $valor * 4;
        }
    }

    public static function converteProteina($valor, $paraGramas = true)
    {
        if ($paraGramas){
            return $valor / 4;
        } else{
            return $valor * 4;
        }
    }

    public static function converteLipideos($valor, $paraGramas = true)
    {
        if ($paraGramas){
            return $valor / 9;
        } else{
            return $valor * 9;
        }
    }

    public static function getProteinaPorcentagem()
    {
        return 0.4;
    }

    public static function getLipideosPorcentagem()
    {
        return 0.2;
    }

    public static function getCarboidratoPorcentagem()
    {
        return 0.4;
    }

    public static function getMacroPorcentagem(){
        return [
            'proteina' => self::getProteinaPorcentagem(),
            'carboidrato' => self::getCarboidratoPorcentagem(),
            'lipideos' => self::getLipideosPorcentagem(),
        ];
    }

    public static function geraRefeicao($pessoa, $macrosNecessarios, $porcentagem, $iterations = 1000, $refeicao = null){

        array_walk($macrosNecessarios, function(&$item) use ($porcentagem){
            $item *= $porcentagem;
        });

        if (!$refeicao){
            $refeicao = new Refeicao();
        }
        for ($i = 0; $i < $iterations; $i++){
            $refeicao = $refeicao->refeicaoStep($macrosNecessarios, $pessoa);
        }

        foreach ($refeicao->getAlimentos() as $alimento){
            alimentoHandler::atualizaIndiceCompatibilidade($alimento->getId(), -0.05, $pessoa->getId());
        }
        return $refeicao;
    }

}