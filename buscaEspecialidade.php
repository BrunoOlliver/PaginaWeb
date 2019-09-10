<?php

class Especialidades{
    public $nome;
    public $id;
}

function getEspecialidades($conn){
    $arrayEspecialidade = "";

    $SQL = "
      SELECT * FROM Especialidade
    ";

    if(! $stmt = $conn->prepare($SQL))
        throw new Exception("Falha na operacao prepare: ".$conn->error);

    if(! $stmt->execute())
        throw new Exception("Falha na operacao execute: ".$stmt->error);

    if(! $stmt->bind_result($id,$nome))
        throw new Exception("Falha na operacao bind_result: ".$stmt->error);

    while($stmt->fetch()){
        $especialidade = new Especialidades();

        $especialidade->nome            = $nome;
        $especialidade->id              = $id;

        $arrayEspecialidades[] = $especialidade;
    }
    return $arrayEspecialidades;
}

$arrayEspecialidades = "";
$msgErro = "";

try{
    $conn = conectaMySQL();
    $arrayEspecialidades = getEspecialidades($conn);

}catch(Exception $e){
    $msgErro = $e->getMessage();
}

?>
