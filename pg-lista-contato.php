<?php
  require "conexaoMySQL.php";

  class Contato{
    public $nome;
    public $email;
    }

  function getContatos($conn){
    $arrayContatos = "";

    $SQL = "
      SELECT Nome, EMail
      FROM Contato
    ";

    if(! $stmt = $conn->prepare($SQL))
      throw new Exception("Falha na operacao prepare: ".$conn->error);

    if(! $stmt->execute())
      throw new Exception("Falha na operacao execute: ".$stmt->error);

    if(! $stmt->bind_result($nome,$email))
      throw new Exception("Falha na operacao bind_result: ".$stmt->error);

    while($stmt->fetch()){
      $contato = new Contato();

      $contato->nome            = $nome;
      $contato->email           = $email;

      $arrayContatos[] = $contato;
    }
    return $arrayContatos;
  }

    $arrayContatos = "";
    $msgErro = "";

    try{
        $conn = conectaMySQL();
        $arrayContatos = getContatos($conn);

    }catch(Exception $e){
        $msgErro = $e->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Contatos</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
      <script src="js/acesso.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>

	<body>
		<!-- CRIAÇÃO DO CABEÇALHO -->
		<?php include "header.php"?>

		<!-- CRIAÇÃO DO MENU -->
    <div id="navbar" style="display:none"><?php include "navbar.php";?></div>
    <div id="navbar-restrito"><?php include "navbar-restrito.php";?></div>
    <?php include "modal.php"; ?>

		<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
		<div class="container mainConteudo">
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Nome</th>
					<th>E-Mail</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 if($arrayContatos != ""){
				 foreach ($arrayContatos as $contato){
					echo"
					 <tr>
						<td>$contato->nome</td>
						<td>$contato->email</td>
					 </tr>
					 ";
				 }
			 }
			?>
			</tbody>
			</table>
		</div>
		<?php
		if($msgErro != "")
		    echo "<h3>Erro: $msgErro</h3>";
		?>
		</div>

		<!-- CRIAÇÃO DO RODAPÉ -->
		<?php include "footer.php"?>
	</body>
</html>
