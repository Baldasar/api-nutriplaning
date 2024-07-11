<?php

class Alimento
{
    public $id;
    public $descricaoAlimento;
    public $categoria;
    public $energiaKcal;
    public $macroNutrientes;
    public $indiceCompatibilidadeGlobal;
    public $indiceCompatibilidadeLocal;
    public $quantidade = 100;


    public function __construct($alimento)
    {
        $this->id = $alimento['id'];
        $this->descricaoAlimento = $alimento['descricaoAlimento'];
        $this->categoria = $alimento['categoria'];
        $this->energiaKcal = $alimento['energiaKcal'];
        $this->macroNutrientes = $alimento['macroNutrientes'];
        $this->indiceCompatibilidadeGlobal = $alimento['indiceCompatibilidadeGlobal'];
        $this->indiceCompatibilidadeLocal = $alimento['indiceCompatibilidadeGlobal'];
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'descricaoAlimento' => $this->descricaoAlimento,
            'categoria' => $this->categoria ,
            'energiaKcal' => $this->energiaKcal,
            'macroNutrientes' => $this->macroNutrientes,
            'quantidade' => $this->quantidade,
            'indiceCompatibilidadeGlobal' => $this->indiceCompatibilidadeGlobal,
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescricaoAlimento()
    {
        return $this->descricaoAlimento;
    }

    /**
     * @param mixed $descricaoAlimento
     */
    public function setDescricaoAlimento($descricaoAlimento)
    {
        $this->descricaoAlimento = $descricaoAlimento;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getEnergiaKcal()
    {
        return $this->energiaKcal;
    }

    /**
     * @param mixed $energiaKcal
     */
    public function setEnergiaKcal($energiaKcal)
    {
        $this->energiaKcal = $energiaKcal;
    }

    /**
     * @return mixed
     */
    public function getMacroNutrientes()
    {
        return $this->macroNutrientes;
    }

    /**
     * @param mixed $macroNutrientes
     */
    public function setMacroNutrientes($macroNutrientes)
    {
        $this->macroNutrientes = $macroNutrientes;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    /**
     * @return mixed
     */
    public function getIndiceCompatibilidadeGlobal()
    {
        return $this->indiceCompatibilidadeGlobal;
    }

    /**
     * @param mixed $indiceCompatibilidadeGlobal
     */
    public function setIndiceCompatibilidadeGlobal($indiceCompatibilidadeGlobal): void
    {
        $this->indiceCompatibilidadeGlobal = $indiceCompatibilidadeGlobal;
        $this->indiceCompatibilidadeLocal = $indiceCompatibilidadeGlobal;
    }

    public function setQuantidade(int $quantidade)
    {
        if ($quantidade == 0){
            return;
        }
        $oldQuantidade = $this->quantidade;

        foreach ($this->macroNutrientes as &$nutriente){
            $nutriente /= ($oldQuantidade/$quantidade);
        }

        $this->energiaKcal /= ($oldQuantidade/$quantidade);
        $this->quantidade = $quantidade;
    }
}
