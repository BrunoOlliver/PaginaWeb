<?php
require "conexaoMySQL.php";

try{
  $conn = conectaMySQL();

  $opcao = isset($_GET['opcao']) ? $_GET['opcao'] : '';
  $valor = isset($_GET['valor']) ? $_GET['valor'] : '';

  if(!empty($opcao)){
    switch($opcao){
      case 'especialidade':{
        echo getEspecialidade();
      }
      case 'estado':{
        echo getEstado();
      }
    }
  }

  function getEspecialidade(){
    $sql = "SELECT Descricao FROM Especialidade";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo json_encode($stmt->fetchAll());
    $conn->close();
  }

  function getEstado(){
    $sql = "SELECT UF FROM Estado";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo json_encode($stmt->fetchAll());
    $conn->close();
  }
}catch(Exception $e){
  $msgErro = $e->getMessage();
}
echo json_encode($stmt->fetchAll());

if($conn != null)
  $conn->close();

?>
