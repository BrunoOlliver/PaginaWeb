<?php

  require "conexaoMySQL.php";

	$paginaAtiva = "paginaContato";

	function filtraEntrada($dado){
	    $dado = trim($dado);
	    $dado = stripslashes($dado);
	    $dado = htmlspecialchars($dado);

	    return $dado;
	}
  $msgErro = "";

  if($_SERVER["REQUEST_METHOD"] == "POST"){

	    $formSucesso = false;

     $nome = $email = $motivo = $mensagem = "";

     $nome                  = filtraEntrada($_POST["nome"]);
     $email                 = filtraEntrada($_POST["email"]);
     $motivo                = filtraEntrada($_POST["motivo"]);
     $mensagem              = filtraEntrada($_POST["mensagem"]);

     try{
       $conn = conectaMySQL();

       $sql = "INSERT INTO Contato(Contato_ID,Nome,EMail,Motivo,Mensagem)
               VALUES(null,?,?,?,?)
              ";

      $stmt = $conn->prepare($sql);

      if(! $stmt->bind_param("ssss",$nome,$email,$motivo,$mensagem))
        throw new Exception("Erro na operacao bind_param: ".$stmt->error);

      if(! $stmt->execute())
          throw new Exception("Erro ao inserir dados".$conn->error);

     $stmt->close();

     $formSucesso = true;
     $conn->commit();

     }catch(Exception $e){
       $conn->rollback();
       $msgErro = $e->getMessage();
     }
   }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Clinica médica</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
  <script src="acesso.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<!-- CRIAÇÃO DO CABEÇALHO -->
<?php include "header.php";?>

<!-- CRIAÇÃO DO MENU -->
<div id="navbar"><?php include "navbar.php";?></div>
<div id="navbar-restrito" style="display:none"><?php include "navbar-restrito.php";?></div>
<?php include "modal.php"; ?>

<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
<div class="container mainConteudo">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <fieldset>
      <legend> Envie uma mensagem para a gente: </legend>

    <!-- LINHA 1 -->
    <div class="row form-group" style="vertical-align:center">
      <label class="control-label col-sm-3" for="busca-especialidade">Nome para Contato:</label>
      <div class="col-sm-7">
        <input type="text" class="form-control" pattern="[A-Za-z\s]+$" name="nome" id="nome" required>
      </div>
    </div>

    <!-- LINHA 2 -->

    <div class="row form-group" style="vertical-align:center">
      <label class="control-label col-sm-3" for="busca-especialidade">E-Mail para Contato:</label>
      <div class="col-sm-7">
        <input type="email" class="form-control" name="email" id="email" required>
      </div>
    </div>

    <!-- LINHA 3 -->
    <div class="row form-group" style="vertical-align:center">
      <label class="control-label col-sm-3" for="busca-especialidade">Escolha um motivo para Mensagem: </label>
      <div class="col-sm-7">
        <select class="form-control" name="motivo" id="motivo">
          <option value="1">Sugestão</option>
          <option value="2">Reclamação</option>
          <option value="3">Elogio</option>
          <option value="4">Dúvida</option>
        </select>
      </div>
    </div>

    <!-- LINHA 4 -->

    <div class="row form-group" style="vertical-align:center">
      <label class="control-label col-sm-3" for="busca-especialidade">Caixa de Mensagem: </label>
      <div class="col-sm-9">
        <textarea class="form-control" row="4" cols="10" maxlength="500" name="mensagem" id="mensagem">
          Digite aqui suas reclamações, sugestões, elogios ou dúvidas...
        </textarea>
      </div>
    </div>


    <!-- CRIAÇÃO DO BOTÃO-->
    <div class="container col-sm-12" style="background: lightgray; padding: 8px; border-radius: 8px" >
      <table class="col-sm-12" style="margin:0 auto; border-style: none">
        <tr style="text-align: center">
        <td><button type="submit" class="btn-info btn-lg">Salvar</button></td>
        <td><button type="reset" class="btn-info btn-lg">Cancelar</button></td>
        </tr>
      </table>
    </div>

    </fieldset>
  </form>
</div>

<!-- CRIAÇÃO DO RODAPÉ -->
<?php include "footer.php";?>

</body>
</html>
