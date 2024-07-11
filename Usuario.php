<?php

class Usuario
{
    public ?int $id = null;
    public string $nome;
    public string $email;
    private string $senha;

    public function __construct(array $usuario)
    {
        if (array_key_exists( "id", $usuario)){
            $this->id = $usuario['id'];
        }

        $this->nome = $usuario['nome'];
        $this->email = $usuario['email'];
        $this->senha = $usuario['senha'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
        ];
    }
}