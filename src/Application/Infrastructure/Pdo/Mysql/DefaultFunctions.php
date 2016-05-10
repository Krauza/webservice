<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

class DefaultFunctions
{
    public static function addConditionsToQuery(array $conditions = null) {
        $query = '';

        if(empty($conditions)) {
            return $query;
        }

        $i = 0;
        foreach($conditions as $key => $value) {
            if($i === 0) {
                $query .= " WHERE ";
            } else {
                $query .= " AND ";
            }

            $query .= "$key='$value'";

            $i++;
        }

        return $query;
    }
}