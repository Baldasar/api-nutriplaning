<?php
include "Alimento.php";
class alimentoHandler
{
    public static function getAlimentoById($id){
        $querybuilder = dbConnectHandler::getQueryBuilder();
        $query = $querybuilder->prepare("
            SELECT *
            FROM alimentos_macro
            WHERE id = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        return self::objetifyAlimento($result->fetch_assoc());
    }
    public static function getRandomAlimento()
    {
        $queryBuilder = dbConnectHandler::getQueryBuilder();

        $queryBuilder = $queryBuilder->query("SELECT COUNT(id) FROM alimentos_macro");
        $result = $queryBuilder->fetch_row();

        $count = $result[0];

        return self::getAlimentoById(random_int(1, $count));
    }

    public static function getRandomWeightedAlimento($pessoa){
        $queryBuilder = dbConnectHandler::getQueryBuilder();

        $query = $queryBuilder->prepare("
            SELECT am.id, am.indiceCompatibilidadeGlobal, (SELECT indice_compatibilidade FROM pessoa_indice_compatibilidade WHERE id_pessoa = ? AND id_alimento = am.id) as d
            FROM alimentos_macro am 
            ORDER BY -LOG(1.0 - RAND()) / d ,
            -LOG(1.0 - RAND()) / am.indiceCompatibilidadeGlobal
        ");

        $id = $pessoa->getId();
        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        $alimento = alimentoHandler::getAlimentoById($result->fetch_assoc()['id']);

        if (in_array($alimento->getCategoria(), $pessoa->getBlackList()) ){
            $alimento = alimentoHandler::getRandomWeightedAlimento($pessoa);
        }
        return $alimento;
    }

    public static function atualizaIndiceCompatibilidade($id , $delta, $pessoa){
        $querybuilder = dbConnectHandler::getQueryBuilder();

        $query = $querybuilder->prepare('
            INSERT INTO 
            pessoa_indice_compatibilidade (id_pessoa, id_alimento, indice_compatibilidade) 
            VALUES(?,?,1) 
            ON DUPLICATE KEY
            UPDATE    
            indice_compatibilidade = indice_compatibilidade + (indice_compatibilidade*?)
        ');

        $query->bind_param("iid",$pessoa, $id, $delta);
        $query->execute();
    }

    public static function toFloat($number){
        return (float)str_replace(",", ".", $number);
    }


    public static function objetifyAlimento($alimento){
        return new Alimento([
            'id' => $alimento['id'],
            'descricaoAlimento' => $alimento['descricaoAlimento'],
            'categoria' => $alimento['categoria'],
            'energiaKcal' => self::toFloat($alimento['energiaKcal']),
            'macroNutrientes' => [
                'proteina' => self::toFloat($alimento['proteina']),
                'carboidrato' => self::toFloat($alimento['carboidrato']),
                'lipideos' => self::toFloat($alimento['lipideos']),
            ],
            'indiceCompatibilidadeGlobal' => $alimento['indiceCompatibilidadeGlobal'],
            ]
        );

    }
}