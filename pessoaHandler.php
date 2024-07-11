<?php
include_once "dbConnectHandler.php";
include_once "Pessoa.php";
class pessoaHandler
{
    public static function getPessoaById($id){
        $querybuilder = dbConnectHandler::getQueryBuilder();
        $query = $querybuilder->prepare("
            SELECT *
            FROM pessoa
            WHERE id = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        return self::objetifyUsuario($result->fetch_assoc());
    }

    public static function getPessoaByUsuario(Usuario $usuario){
        $querybuilder = dbConnectHandler::getQueryBuilder();
        $query = $querybuilder->prepare("
            SELECT *
            FROM pessoa
            WHERE usuario = ?
        ");

        $idUsuario = $usuario->getId();
        $query->bind_param("i", $idUsuario);
        $query->execute();

        $result = $query->get_result();

        return self::objetifyUsuario($result->fetch_assoc());
    }

    public static function createPessoa(Pessoa $pessoa){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            INSERT INTO pessoa (usuario, nome, altura, peso, idade ,genero, atividade_fisica, black_list)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $pessoa = $pessoa->toArray();
        $blackList = json_encode($pessoa['black_list']);
        $query->bind_param("isiiisds", $pessoa['usuario'], $pessoa['nome'], $pessoa['altura'], $pessoa['peso'], $pessoa['idade'],$pessoa['genero'], $pessoa['atividade_fisica'] , $blackList);
        $query->execute();

        return ($query->insert_id);
    }

    public static function updatePessoa(Pessoa $pessoa){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            UPDATE pessoa
            SET altura = ?, peso = ?, idade = ?, genero = ?, atividade_fisica = ?, black_list = ?
            WHERE id = ?
        ");

        $pessoa = $pessoa->toArray();
        $blackList = json_encode($pessoa['black_list']);
        $query->bind_param("iiisdsi",    $pessoa['altura'], $pessoa['peso'],$pessoa['idade'], $pessoa['genero'], $pessoa['atividade_fisica'], $blackList ,$pessoa['id']);
        $query->execute();
    }

    public static function removePessoa(Pessoa $pessoa){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            DELETE FROM pessoa
            WHERE id = ?
        ");

        $pessoa = $pessoa->toArray();
        $query->bind_param("i",   $pessoa['id']);
        $query->execute();
    }
    public static function toFloat($number){
        return (float)str_replace(",", ".", $number);
    }

    public static function objetifyUsuario($pessoa){
        if (!$pessoa){
            return null;
        }

        $pessoa['black_list'] = json_decode($pessoa['black_list']);
        return new Pessoa($pessoa);
    }


}