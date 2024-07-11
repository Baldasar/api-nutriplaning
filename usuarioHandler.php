<?php
include_once "Usuario.php";
class usuarioHandler
{
    public static function getUsuarioById($id){
        $querybuilder = dbConnectHandler::getQueryBuilder();
        $query = $querybuilder->prepare("
            SELECT *
            FROM usuario
            WHERE id = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        return self::objetifyUsuario($result->fetch_assoc());
    }

    public static function attemptLogin($email, $senha){
        $querybuilder = dbConnectHandler::getQueryBuilder();
        $query = $querybuilder->prepare("
            SELECT *
            FROM usuario
            WHERE email = ? AND senha = ?
        ");

        $query->bind_param("ss", $email, $senha);
        $query->execute();

        $result = $query->get_result();

        if (!$result->num_rows){
            return false;
        }
        return self::objetifyUsuario($result->fetch_assoc());
    }

    public static function createUsuario(Usuario $usuario){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            INSERT INTO usuario (nome, email, senha)
            VALUES (?, ?, ?)
        ");

        $usuario = $usuario->toArray();
        $query->bind_param("sss", $usuario['nome'], $usuario['email'], $usuario['senha']);
        $query->execute();

        return ($query->insert_id);
    }

    public static function updateUsuario(Usuario $usuario){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            UPDATE usuario
            SET nome = ?, email = ?, senha = ?
            WHERE id = ?
        ");

        $usuario = $usuario->toArray();
        $query->bind_param("sssi",  $usuario['nome'], $usuario['email'], $usuario['senha'], $usuario['id']);
        $query->execute();
    }

    public static function removeUsuario(Usuario $usuario){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare("
            DELETE FROM usuario
            WHERE id = ?
        ");

        $usuario = $usuario->toArray();
        $query->bind_param("i",   $usuario['id']);
        $query->execute();

    }
    public static function toFloat($number){
        return (float)str_replace(",", ".", $number);
    }

    public static function objetifyUsuario($usuario){
        if (!$usuario){
            return null;
        }
        return new Usuario($usuario);
    }


}