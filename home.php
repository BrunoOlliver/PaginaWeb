<?php
	$paginaAtiva = "paginaHome";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Clinica médica</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="js/acesso.js"></script>
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
		<div class="css col-sm-12">
		<table style="vertical-align:center; horizontal-align:center; ">
			<tr>
				<td style="text-align:center">
					<img style="border-radius:10px; horizontal-align:center; padding:10px; border-style:solid; border-color: gray;" height="200px 600px; float: center;" src="img/painel.jpg">
				</td>
			</tr>
			<tr>
				<td>
				<ul>
					<li style="font-style:bold; font-size:25px">Conheça nossa Hisória</li>
					<p style="text-align:justify">Há 5 anos tratando nossos pacientes com maior cuidado e carinho,
					surgimos da união de uma associação médica de especialistas renomados do Brasil. Aqui você
					terá o melhor atendimento de prontidão, com sistema ambulatório 24 horas que procura trazer
					confiança e segurança para uma atendimento rápido sempre com prioridade na preservação da vida humana.
					Estamos sempre aperfeiçoando nossos sistemas de atendimento, trazendo mais conforto aos pacientes
					que estão internados e também aos seus familiares que visitam frequentemente.
					</p>
					<li style="font-style:bold; font-size:25px">Especialidades Médicas</li>
					<p style="text-align:justify"> Nossos atendimentos vão desde: Acupuntura, Alergia e Imunologia,Cancerologia, Cardiologia,
						Cirurgia Cardiovascular, Cirurgia Geral, Dermatolgia, Endoscopia, Geriatria, Ginecologia e Obstetricia,
						Hematologia e Hemoterapia, Homeopatia, Infectologia, Neurocirurgia, Obstetricia, Oftalmologia,
						Ortopedia e Traumatologia, Patologia, Pediatria, Psiquiatria, Radioterapia, Reumatologia, Urologia
						entre outros. Para conhecer mais acesse a página de agendamento e verifique os médicos disponíveis
						 em cada especialidade médica.
					</p>
					<li style="font-style:bold; font-size:25px">Consultas e Agendamentos</li>
					<p style="text-align:justify">Podem ser feitas pelo próprio site, caso haja disponibilidade de horário. Uma vez agendada
						será ligado para o paciente confirmando dia e horárioa da consulta e os valores do atendimento.
					</p>
					<li style="font-style:bold; font-size:25px">Fale conosco</li>
					<p style="text-align:justify">É possível em nosso portal de atendimento realizar envios de mensagens para fazer sugestões, reclamações,
					elogios e tirar suas dúvidas sobre qualquer processo de atendimento ou mesmo sobre qual atendimento correto que você
					precisa.
					</p>
				</ul>
				</td>
			</tr>
		</table>
	</div>
</div>

<!-- CRIAÇÃO DO RODAPÉ -->
<?php include "footer.php";?>

</body>
</html>
