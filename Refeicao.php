<?php
include "alimentoHandler.php";
class Refeicao
{

    public array $randomDistribution = [
        'add' => 10,
        'remove' => 10,
        'change' => 80,
    ];

    public array $alimentos = [];

    public function getAlimentos($ref = true): array
    {
        return $this->alimentos;
    }

    public function addAlimento(Alimento $alimento){
        $this->alimentos[] = $alimento;
    }

    public function removeAlimento($key){
        unset($this->alimentos[$key]);
        $this->alimentos = array_values($this->alimentos);
    }
    public function clearAlimentos(){
        $this->alimentos = [];
    }

    public function setAlimentos(array $alimentos): void
    {
        $this->alimentos = $alimentos;
    }

    public function getTotalMacroNutrientes(){
        $totalMacros = [
            'proteina' => 0,
            'carboidrato' => 0,
            'lipideos' => 0,
        ];

        foreach ($this->alimentos as $alimento){
            $nutrientes = $alimento->getMacronutrientes();
            $totalMacros['proteina'] += $nutrientes['proteina'];
            $totalMacros['carboidrato'] += $nutrientes['carboidrato'];
            $totalMacros['lipideos'] += $nutrientes['lipideos'];
        }

        return $totalMacros;
    }

    public function calculaPrecisaoRefeicao($necessidadesNutricionais){
        $totalMacrosRefeicao = $this->getTotalMacroNutrientes();
        $precisaoMacros = [];
        foreach ($totalMacrosRefeicao as $label => $macroRefeicao){
            $precisaoMacros[$label] = ($necessidadesNutricionais[$label] - $macroRefeicao);
            if ($precisaoMacros[$label] <= 0){
                $precisaoMacros[$label] = abs($precisaoMacros[$label]) * 2;
            }
        }

        return array_sum($precisaoMacros);
    }

    public function addRandomAlimento(){
        $alimento1 = alimentoHandler::getRandomAlimento();
        $alimento2 = alimentoHandler::getRandomAlimento();

        if ($alimento1->getIndiceCompatibilidadeGlobal() * lcg_value() > $alimento2->getIndiceCompatibilidadeGlobal() * lcg_value()){
            $this->addAlimento($alimento1);
        } else{
            $this->addAlimento($alimento2);
        }
    }

    public function addRandomWeightedAlimento($pessoa){
         $this->addAlimento(alimentoHandler::getRandomWeightedAlimento($pessoa));
    }

    public function removeRandomAlimento(){
        $this->removeAlimento(random_int(0,max(count($this->alimentos)-1, 0)));
    }

    public function changeRandomAlimento()
    {

        $this->alimentos = array_values($this->alimentos);
        $key = random_int(0,count($this->alimentos)-1);

        $this->alimentos[$key]->setQuantidade( $this->alimentos[$key]->getQuantidade() + random_int(-100, 100));
        if ($this->alimentos[$key]->getQuantidade() <= 0){
            $this->removeAlimento($key);
        }
    }


    public function cloneAlimentos(){
        $endAlimentos = [];
        foreach ($this->getAlimentos() as $alimento){
            $endAlimentos[] =  clone $alimento;
        }
        return $endAlimentos;
    }

    public function refeicaoStep($necessidadesNutricionais, $pessoa){
        $newRefeicao = new Refeicao();
        $newRefeicao->setAlimentos($this->cloneAlimentos());

        if (count($newRefeicao->getAlimentos()) > 0){
            if (random_int(0, 100) < $this->randomDistribution['change']){
                $newRefeicao->changeRandomAlimento();
            }

            if (random_int(0, 100) < $this->randomDistribution['add']){
                $newRefeicao->addRandomWeightedAlimento($pessoa);
            }

            if (random_int(0, 100) < $this->randomDistribution['remove']){
                $newRefeicao->removeRandomAlimento();
            }
        } else{
            $newRefeicao->addRandomWeightedAlimento($pessoa);
        }

        if ((float)$newRefeicao->calculaPrecisaoRefeicao($necessidadesNutricionais) < (float)$this->calculaPrecisaoRefeicao($necessidadesNutricionais)){
            return $newRefeicao;
        } else{
            return $this;
        }
    }
}