<?php

class Pessoa
{
    public ?int $id = null;
    public ?int $usuario = null;
    private ?string $nome = null;
    public int $altura;
    public int $peso;
    public string $genero;
    public int $idade;
    public float $atividadeFisica;
    public ?array $blackList = [];



    public function __construct(array $pessoa)
    {

        if (array_key_exists( "id", $pessoa)){
            $this->id = $pessoa['id'];
        }
        if (array_key_exists("usuario", $pessoa)){
            $this->usuario = $pessoa['usuario'];
        }
        if (array_key_exists("nome", $pessoa)){
            $this->nome = $pessoa['nome'];
        }

        $this->altura = $pessoa['altura'];
        $this->peso = $pessoa['peso'];
        $this->genero = $pessoa['genero'];
        $this->idade = $pessoa['idade'];
        $this->atividadeFisica = $pessoa['atividade_fisica'];

        if (array_key_exists("black_list", $pessoa)){
            $this->blackList = $pessoa['black_list'];
        }

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsuario(): int
    {
        return $this->usuario;
    }

    public function setUsuario(int $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getAltura(): int
    {
        return $this->altura;
    }

    public function setAltura(int $altura): void
    {
        $this->altura = $altura;
    }

    public function getPeso(): int
    {
        return $this->peso;
    }

    public function setPeso(int $peso): void
    {
        $this->peso = $peso;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    public function getAtividadeFisica(): float
    {
        return $this->atividadeFisica;
    }

    public function setAtividadeFisica(float $atividadeFisica): void
    {
        $this->atividadeFisica = $atividadeFisica;
    }

    public function getIdade(): int
    {
        return $this->idade;
    }

    public function setIdade(int $idade): void
    {
        $this->idade = $idade;
    }

    public function getBlackList(){
        return $this->blackList;
    }

    public function setBlackList(?array $blackList){
        $this->blackList = $blackList;
    }


    public function toArray(){
        return [
            'id' => $this->id,
            'usuario' => $this->usuario,
            'nome' => $this->nome,
            'altura' => $this->altura,
            'peso' => $this->peso,
            'genero' => $this->genero,
            'idade' => $this->idade,
            'atividade_fisica' => $this->atividadeFisica,
            'black_list' => $this->blackList,
        ];
    }
}