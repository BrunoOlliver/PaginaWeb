<?php
  require "conexaoMySQL.php";

  $especialidade = $_REQUEST['$especialidade'];

  $sql = "SELECT * FROM Funcionario WHERE Especialidade_ID = $especialidade ORDER BY Nome";
  $result = mysqli_query($conn, $sql);

  while ($row[] = mysqli_fetch_assoc($result)){
    $arrayMedicos[] = array(
      'Funcionario_ID'          =>  $row['Funcionario_ID'],
      'Nome'        =>  utf8_encode($row['Nome']),
    );
  }
echo(json_encode($arrayMedicos));
?>
