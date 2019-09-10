<?php
  require "conexaoMySQL.php";

  class Funcionario{
    public $nome;
    public $cargo;
    public $sexo;
    public $rg;
    public $logradouro;
    public $cidade;
  }

  function getFuncionarios($conn){
    $arrayFuncionarios = "";

    $SQL = "
      SELECT f.Nome as Funcionario,
             f.Cargo as Funcionario,
             f.Sexo as Funcionario,
             f.RG as Funcionario,
             e.Logradouro as EnderecoFunc,
             e.Cidade as EnderecoFunc
      FROM Funcionario f, EnderecoFunc e
      WHERE f.Funcionario_ID = e.Endereco_ID
    ";

    if(! $stmt = $conn->prepare($SQL))
      throw new Exception("Falha na operacao prepare: ".$conn->error);

    if(! $stmt->execute())
      throw new Exception("Falha na operacao execute: ".$stmt->error);

    if(! $stmt->bind_result($nome,$cargo,$sexo,$rg,$logradouro,$cidade))
      throw new Exception("Falha na operacao bind_result: ".$stmt->error);

    while($stmt->fetch()){
      $funcionario = new Funcionario();

      $funcionario->nome            = $nome;
      $funcionario->cargo           = $cargo;
      $funcionario->sexo            = $sexo;
      $funcionario->rg              = $rg;
      $funcionario->logradouro      = $logradouro;
      $funcionario->cidade          = $cidade;

      $arrayFuncionarios[] = $funcionario;
    }
    return $arrayFuncionarios;
  }

    $arrayFuncionarios = "";
    $msgErro = "";

    try{
        $conn = conectaMySQL();
        $arrayFuncionarios = getFuncionarios($conn);

    }catch(Exception $e){
        $msgErro = $e->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Funcionarios</title>
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
    <div id="navbar-restrito" ><?php include "navbar-restrito.php";?></div>
    <?php include "modal.php"; ?>

		<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
		<div class="container mainConteudo">
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Sexo</th>
					<th>Cargo</th>
					<th>RG</th>
					<th>Logradouro</th>
					<th>Cidade</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 if($arrayFuncionarios != ""){
				 foreach ($arrayFuncionarios as $funcionario){
					echo"
					 <tr>
						<td>$funcionario->nome</td>
						<td>$funcionario->sexo</td>
						<td>$funcionario->cargo</td>
						<td>$funcionario->rg</td>
						<td>$funcionario->logradouro</td>
						<td>$funcionario->cidade</td>
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
