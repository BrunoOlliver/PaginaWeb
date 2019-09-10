<?php

define("HOST","fdb15.awardspace.net");
define("USER","2481067_sql");
define("PASSWORD","PPI_11511224");
define("DATABASE","2481067_sql");


function conectaMySQL(){
    $conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

    if($conn->connect_error)
        throw new Exception('Falha na conexao: '.$conn->connect_error);
  
    return $conn;
}
?>
