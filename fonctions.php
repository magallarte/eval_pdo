<?php

/**
 * Connecte à la bd
 * @param
 * @return  object
**/
function connectDB()
{
    try
    {
        $pdo =  new PDO( SGBD . ':host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8mb4', USER, PWD, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION] );
    }
     catch( PDOException $e )
    {
        die( $e->getMessage() );
    }
    return $pdo;
}

/**
 * Effectue une requete SQL
 * @param  string $sql    	la requete SQL
 * @param  array $params 	Un tableau associatif de la forme ['placeholder' => valeur]
 * @return PDOStatement     le retour de la requete
 */

function makeStatement($sql, $params = [])
{
    $pdo = connectDB();
    if(empty($params))
    {
        return $pdo->query($sql);
    }
    else
    {
        $statement = $pdo->prepare($sql);
        foreach ($params as $key => $value)
        {
            $statement->bindValue($key, $value);
        }
        $statement->execute();

        return $statement;
    }
}


function makeSelect($sql, $params = [], $fetchStyle = PDO::FETCH_ASSOC, $fetchArg = null)
{
    $statement = makeStatement($sql, $params);

    if(is_null($fetchArg))
    {
        $result = $statement->fetchAll($fetchStyle);
    }
    else
    {
        $result = $statement->fetchAll($fetchStyle, $fetchArg);
    }
    $statement->closeCursor();

    return $result;
}