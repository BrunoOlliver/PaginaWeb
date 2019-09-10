<?php
  class Acesso(){
    $user;
    $password;
  }
  try{
    require "conexaoMySQL.php";
    $conn = conectaMySQL();

    $acesso    = "";
    $user      = "";
    $password  = "";

    if(isset($_POST["user"])){
      $user = $_POST["user"];
    }

    if(isset($_POST["password"])){
      $password = $_POST["password"];
    }

    $SQL = "SELECT usuario, senha FROM AcessoADM
            WHERE usuario = '$user' AND senha = '$password';
            ";

    if(! $result = $conn->query($SQL))
      throw new Exception("Falha na busca: ".$conn->error);

    if($result->num_row > 0){
      $row = $result->fetch_assoc();
      $acesso                 = new Acesso();

      $acesso->user           = $row["usuario"];
      $acesso->password       = $senha["senha"];

    }
    $jsonStr = json_encode($acesso);
    echo $jsonStr;

  }catch(Exception $e){
      $msgErro = $e->getMessage();
  }

  if($conn != null)
    $conn->close();
?>
