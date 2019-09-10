<?php

class MedicoEspecialista{
    public $especialidade;
    public $id_medico;
    public $nome_medico;
    public $cargo;
}
$especialidade_id = $_REQUEST["especialidade"];

function getMedicoEspecialista($conn){
  $arrayEspecialista = "";

  $SQL = "SELECT Funcionario_ID, Nome, Especialidade_ID, Cargo
          FROM Funcionario
          WHERE Especialidade_ID = $especialidade_id
          ORDER BY Name";

  if(! $stmt = $conn->prepare($SQL))
    throw new Exception("Falha na operacao prepare: ".$conn->error);

  if(! $stmt->execute())
    throw new Exception("Falha na operacao execute: ".$stmt->error);

  if (! $stmt->bind_result($id_medico,$nome_medico,$especialidade,$cargo))
    throw new Exception("Falha na operacao bind_result: ".$stmt->error);

  while($stmt->fetch()){
      $especialista = new MedicoEspecialista();

      $especialista->id_medico      = $id_medico;
      $especialista->nome_medico    = $nome_medico;
      $especialista->especialidade  = $especialidade;
      $especialista->cargo          = $cargo;

      $arrayEspecialista[]          = $especialista;

  }
  return $arrayEspecialista;
}

$arrayEspecialista = "";
$msgErro = "";

try{
    $conn = conectaMySQL();
    $arrayEspecialista = getMedicoEspecialista($conn);
    echo (json_encode($arrayEspecialista));

}catch(Exception $e){
    $msgErro = $e->getMessage();
}

?>
