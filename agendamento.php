
<?php

  require "conexaoMySQL.php";
  require "buscaMedicoPorEspecialidade.php";
  require "buscaEspecialidade.php";

	$paginaAtiva = "paginaAgendamento";

	function filtraEntrada($dado){
	    $dado = trim($dado);
	    $dado = stripslashes($dado);
	    $dado = htmlspecialchars($dado);

	    return $dado;
	}
  $msgErro = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

	    $formSucesso = false;

	    $data = $hora = $funcionario = $paciente = "";
			$nome = $fone = $celular = "";

	    $data                    = filtraEntrada($_POST["data"]);
	    $hora                    = filtraEntrada($_POST["hora"]);
	    $funcionario             = filtraEntrada($_POST["funcionario"]);
	    $paciente                = filtraEntrada($_POST["paciente"]);
	    $nome                    = filtraEntrada($_POST["nome"]);
	    $fone   		             = filtraEntrada($_POST["fone"]);
	    $celular                 = filtraEntrada($_POST["celular"]);

	    try{
	        $conn = conectaMySQL();

	        $conn->begin_transaction();

          /*Inserindo dados na Tabela Paciente*/
          $sql = "
									INSERT INTO Paciente(Paciente_ID,Nome,Telefone,Celular)
                  VALUES (null,?,?,?);
                   ";
          $stmt = $conn->prepare($sql);

          if(! $stmt->bind_param("sss",$nome,$fone,$celular))
            throw new Exception("Erro na operacao bind_param: ".$stmt->error);


          if(! $stmt->execute())
              throw new Exception("Erro ao inserir dados".$conn->error);

					/*Resgata o id do ultimo registro*/
					$paciente_id = $conn->insert_id;
          $stmt->close();

					/*Inserindo dados na Tabela Agenda*/
	        $sql = "
									INSERT INTO Agenda(Agenda_ID, Data, Hora, Funcionario_ID, Paciente_ID)
	                VALUES (null,?,?,?,?);
	              ";
	        $stmt = $conn->prepare($sql);

	        if(! $stmt->bind_param("iisi",$data, $hora, $funcionario, $paciente_id))
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
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
      <script src="acesso.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>

	<script>
		$(document).ready(function mostraTabela(){
			$("#botao-especialidade").click(function(){
				$("#tabela-especialidade").slideToggle(100).show();
				var busca=$("#busca-especialidade").val();

				if(busca == "")
					$("#tabela-especialidade").hide();
			});
		});

    /*Filtra especialidade com funcionario*/
    $('#especialidade').change(function(){
      if($(this.val())){
        $getJSON('buscaMedico.php?search=',{especialidade:$(this).val(), ajax : 'true'},
        function(j){
          var ( i = 0; i<j.length; i++){
            options += "<option value="' + j[i].Funcionario_ID +'">' + j[i].Nome +'</option>";
          }
          $("#id_medico").html(options).show();
        }
      }else{
        $('#id_medico').html("<option value="">Selecione a subcategoria</option>");
      }
    });
	</script>

	<body>

		<!-- CRIAÇÃO DO CABEÇALHO -->
		<?php include "header.php"?>

		<!-- CRIAÇÃO DO MENU -->
    <div id="navbar" style="display:none"><?php include "navbar.php";?></div>
    <div id="navbar-restrito"><?php include "navbar-restrito.php";?></div>
    <?php include "modal.php"; ?>

		<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
		<div class="container mainConteudo">
			<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    			<fieldset>
    				<legend>Busca e Agendamento: </legend>

    			<!-- LINHA1 -->
    			<div class="row form-group">

    				<label class="control-label col-sm-3">Especialidade Médica Desejada:</label>
    				<div class="col-sm-8">
    					<select class="form-control" value= "(this).value" name="especialidade" id="especialidade">
                <?php
                   if($arrayEspecialidades != ""){
                       foreach ($arrayEspecialidades as $dado){
                           echo "
                             <option value='$dado->id'>$dado->nome</option>;
                             ";
                       }
                   }
                ?>
    					</select>
    				</div>
    			</div>

    			<!-- LINHA2 -->
    			<div class="row form-group">
    				<label class="control-label col-sm-3">Nome do Médico para Consulta:</label>
    				<div class="col-sm-8">
    					<select class="form-control" name="id_medico" id="id_medico">
                <option value="">Escolha subcategoria</option>
    					</select>
    				</div>
    			</div>

    			<!-- LINHA3 -->
    			<div class="row form-group">
    				<label class="control-label col-sm-3" for="data">Datas disponíveis:</label>
    				<div class="col-sm-3">
    					<input type="date" class="form-control" id="data" name="data">
    				</div>

    				<label class="control-label col-sm-2" for="hora">Horários disponíveis: </label>
					<div class="col-sm-3">
    					<select class="form-control" name="hora" id="hora">
							<option value="8">8:00</option>
							<option value="9">9:00</option>
							<option value="10">10:00</option>
							<option value="11">11:00</option>
							<option value="12">12:00</option>
							<option value="13">13:00</option>
							<option value="14">14:00</option>
							<option value="15">15:00</option>
							<option value="16">16:00</option>
							<option value="17">17:00</option>
						  </select>
						<!-- Deve ser substituido por código PHP e busca em SGBD -->
					</div>
				</div>

    			<!-- LINHA4 -->
    			<div class="row form-group" style="vertical-align:center">
    				<label class="control-label col-sm-3" for="busca-especialidade">Busca por Especialidade Médica: </label>
    				<div class="col-sm-7">
    					<input type="text" class="form-control" name="busca-especialidade" id="busca-especialidade">
    				</div>
    				<div class="col-sm-2">
    					<button type="button" class="btn-info btn-lg" onclick="mostraTabela()" id="botao-especialidade">Buscar</button>
    				</div>
    			</div>
    			</fieldset>

    			<fieldset>
    				<legend>Informações do Paciente:</legend>

    			<!-- LINHA5 -->
    			<div class="row form-group">
        			<label class="control-label col-sm-2" for="nome">Nome do Paciente: </label>
        			<div class="col-sm-4">
        				<input class="form-control" type="text" name="nome" id="nome" pattern="[A-Za-z\s]+$" placeholder="Digite o nome do paciente." required>
        			</div>
        			<label class="control-label col-sm-1" for="fone">Telefone: </label>
        			<div class="col-sm-2">
        				<input class="form-control" type="text" name="fone" id="fone" pattern="^\(d[0-9]{2})\d[0-9]{4}-\d[0-9]{4}$" placeholder="(XX) XXXX-XXXX" required>
        			</div>
        			<label class="control-label col-sm-1" for="celular">Celular: </label>
        			<div class="col-sm-2">
        				<input class="form-control" type="text" name="celular" id="celular" pattern="^\(d[0-9]{2})\d[0-9]{5}-\d[0-9]{4}$" placeholder="(XX) XXXXX-XXXX">
        			</div>
    			</div>

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
		<?php include "footer.php"?>
	</body>
</html>
