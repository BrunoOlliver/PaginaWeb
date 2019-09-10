<?php
  require "conexaoMySQL.php";

  class Agendamento{
    public $nome;
    public $especialidade;
    public $data;
    public $paciente;
    public $telefone;
  }

  function getAgendamentos($conn){
    $arrayAgendamentos = "";

    $SQL = "
      SELECT f.Nome_ID AS Funcionario,
						 f.Especialidade As Funcionario,
						 a.Data AS Agenda,
						 a.Hora As Agenda,
						 p.Nome As Paciente,
						 p.Telefone As Paciente
			FROM Funcionario f, Agenda a, Paciente p
      WHERE a.Funcionario_ID = f.Nome_ID
			AND 	a.Paciente_ID = p.Paciente_ID
    ";

    if(! $stmt = $conn->prepare($SQL))
      throw new Exception("Falha na operacao prepare: ".$conn->error);

    if(! $stmt->execute())
      throw new Exception("Falha na operacao execute: ".$stmt->error);

    if(! $stmt->bind_result($nome,$cargo,$sexo,$rg,$logradouro,$cidade))
      throw new Exception("Falha na operacao bind_result: ".$stmt->error);

    while($stmt->fetch()){
      $agendamento = new Funcionario();

      $agendamento->nome           				= $nome;
      $agendamento->especialidade         = $especialidade;
      $agendamento->data            			= $data;
			$agendamento->hora            			= $hora;
      $agendamento->paciente              = $paciente;
      $agendamento->telefone     					= $telefone;

      $arrayAgendamentos[] = $agendamento;
    }
    return $arrayAgendamentos;
  }

    $arrayAgendamentos = "";
    $msgErro = "";

    try{
        $conn = conectaMySQL();
        $arrayAgendamentos = getAgendamentos($conn);

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
    <div id="navbar-restrito"><?php include "navbar-restrito.php";?></div>
    <?php include "modal.php"; ?>

		<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
		<div class="container mainConteudo">
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Nome do Médico</th>
					<th>Especialidade Médica</th>
					<th>Data da Consulta</th>
					<th>Hora Marcada</th>
					<th>Nome do Paciente</th>
					<th>Telefone do Paciente</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 if($arrayAgendamentos != ""){
				 foreach ($arrayAgendamentos as $agendamento){
					echo"
					 <tr>
						<td>$agendamento->nome</td>
						<td>$agendamento->especialidade</td>
						<td>$agendamento->data</td>
						<td>$agendamento->hora</td>
						<td>$funcionario->paciente</td>
						<td>$funcionario->telefone</td>
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
