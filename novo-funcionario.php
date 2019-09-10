<?php

  require "conexaoMySQL.php";
  require "buscaEspecialidade.php";

	$paginaAtiva = "paginaCadastro";

	function filtraEntrada($dado){
	    $dado = trim($dado);
	    $dado = stripslashes($dado);
	    $dado = htmlspecialchars($dado);

	    return $dado;
	}
  $msgErro = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

	    $formSucesso = false;

	    $nome = $cargo = $especialidade = $estadoCivil = $sexo = $dataNascimento = $cpf = $rg = "";
	    $cep = $logradouro = $numero = $complemento = $bairro = $cidade  = $uf = "";

      $especialidade_id   = $_POST["especialidade_id"];
	    $nome               = filtraEntrada($_POST["nome"]);
	    $cargo              = filtraEntrada($_POST["cargo"]);
	    $especialidade      = filtraEntrada($_POST["especialidade"]);
	    $estadoCivil        = filtraEntrada($_POST["estadoCivil"]);
	    $sexo               = filtraEntrada($_POST["sexo"]);
	    $dataNascimento     = filtraEntrada($_POST["dataNascimento"]);
	    $cpf                = filtraEntrada($_POST["cpf"]);
	    $rg                 = filtraEntrada($_POST["rg"]);
	    $cep                = filtraEntrada($_POST["cep"]);
	    $logradouro         = filtraEntrada($_POST["logradouro"]);
	    $numero             = filtraEntrada($_POST["numero"]);
	    $complemento        = filtraEntrada($_POST["complemento"]);
	    $bairro             = filtraEntrada($_POST["bairro"]);
	    $cidade             = filtraEntrada($_POST["cidade"]);
	    $uf                 = filtraEntrada($_POST["uf"]);

	    try{
	        $conn = conectaMySQL();

	        $conn->begin_transaction();

          /*Inserindo dados na Tabela Funcionario*/
	        $sql = "INSERT INTO Funcionario(Funcionario_ID, Nome, Cargo, Especialidade_ID, Estado_Civil, Sexo, Data_Nascimento, CPF, RG)
                    VALUES (null,?,?,?,?,?,?,?,?);
                  ";
          $stmt = $conn->prepare($sql);

	        if(! $stmt->bind_param("ssisssss",$nome, $cargo, $especialidade, $estadoCivil, $sexo, $dataNascimento, $cpf, $rg))
            throw new Exception("Erro na operacao bind_param: ".$stmt->error);

          if(! $stmt->execute())
              throw new Exception("Erro ao inserir dados".$conn->error);

          /*Retorna o primeiro valor ID do INSERT INTO*/

          $conn->query($stmt);
          $insere_id = $conn->insert_id;
          $stmt->close();

          /*Inserindo dados na Tabela EnderecoFunc*/

          $sql = "INSERT INTO EnderecoFunc(Endereco_ID,Funcionario_ID,CEP, Logradouro, Numero, Complemento, Bairro, Cidade, UF)
                    VALUES (null,?,?,?,?,?,?,?,?);
                   ";
          $stmt = $conn->prepare($sql);

          if(! $stmt->bind_param("ississss",$insere_id,$cep,$logradouro,$numero,$complemento,$bairro,$cidade,$uf))
            throw new Exception("Erro na operacao bind_param: ".$stmt->error);

          if(! $stmt->execute())
              throw new Exception("Erro ao inserir dados".$conn->error);

          $stmt->close();

	        $formSucesso = true;
	        $conn->commit();

	    }catch(Exception $e){

	        $conn->rollback();
	    //    $msgErro = $e->getMessage();
	    }
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Novo Funcionario</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
      <script src="js/acesso.js"></script>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/especialidade.js"></script>
  </head>

	<body>

		<!-- CRIAÇÃO DO CABEÇALHO -->
		<?php include "header.php"?>

		<!-- CRIAÇÃO DO MENU -->
    <div id="navbar"><?php include "navbar.php";?></div>
    <div id="navbar-restrito" style="display:none"><?php include "navbar-restrito.php";?></div>
    <?php include "modal.php"; ?>

		<!-- CRIAÇÃO DO CORPO DA PÁGINA -->
		<div class="container mainConteudo">
			<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<fieldset>
				<legend>Dados Pessoais: </legend>

				<!-- LINHA1 -->
				<div class= "row form-group">

					<label class="control-label col-sm-1" for= "nome">Nome: </label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="nome" id="nome" pattern="[A-Za-z\s]+$" placeholder="Digite o nome para cadastro" required>
					</div>

					<label class="control-label col-sm-2" for= "dataNascimento">Data de Nascimento: </label>
					<div class="col-sm-3">
						<input type="date" class="form-control" name="dataNascimento" id="dataNascimento" required>
					</div>
				</div>


				<!-- LINHA2 -->
				<div class= "row form-group">
					<label class="control-label col-sm-1" for= "sexo">Sexo: </label>
					<div class="radio col-sm-2">
						<label><input type="radio" value="masculino" name="sexo" checked>Masculino</label>
						<br>
						<label><input type="radio" value="feminino" name="sexo"> Feminino</label>
					</div>

					<label class="control-label col-sm-2" for= "estadoCivil">Estado Civil: </label>
					<div class="checkbox col-sm-2">
						<label for="solteiro">
							<input type="checkbox" value="solteiro" name="estadoCivil" checked>Solteiro
						</label>
						<label for="casado">
							<input type="checkbox" value="casado" name="estadoCivil">Casado
						</label>
						<br>
						<label for="divorciado">
							<input type="checkbox" value="divorciado" name="estadoCivil">Divorciado
						</label>
						<label for="viuvo">
							<input type="checkbox" value="viuvo" name="estadoCivil">Viúvo
						</label>
					</div>


					<label class="control-label col-sm-2" for="cargo">Cargo:</label>
					<div class="select col-sm-3">
						<select class="form-control" name="cargo" id="opcaoSelect" onkeyup="mostraEspecialidades(this.value)">
							<option value="Medico">Médico</option>
							<option value="Enfermeiro">Enfermeiro</option>
							<option value="Secretario">Secretário</option>
						</select>
					</div>
				</div>

				<!-- LINHA3 -->
				<div class="row form-group">
    				<div class="col-sm-7">
    				</div>
					<label class="control-label col-sm-2" for="especialidade" id="label-especialidade" style="display:none">Especialidades:</label>
					<div class="select col-sm-3" id="lista-especialidade" style="display:none">
						<select class="form-control" name="especialidade" id="especialidade">
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
			</fieldset>

			<!-- LINHA4 -->
			<fieldset>
    			<div class="row form-group">
    				<legend>Documentos: </legend>
    				<label class="control-label col-sm-1" for="cpf">CPF:</label>
    				<div class="col-sm-3">
    					<input type="text" class="form-control" name="cpf" id="cpf" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$" placeholder="XXX.XXX.XXX-XX">
    				</div>

    				<label class="control-label col-sm-1" for="rg">RG: </label>
    				<div class="col-sm-3">
    					<input type="text" class="form-control" name="rg" id="rg" pattern="^[0-9]{2}.[0-9]{3}.[0-9]{3}$" placeholder="XX.XXX.XXX">
    				</div>
    			</div>
			</fieldset>

			<!-- LINHA5 -->
			<fieldset>
			<div class="row form-group">
			<legend>Endereço: </legend>
				<label class="control-label col-sm-2" for="cep">CEP:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="cep" id="cep" pattern="[0-9]{2}[0-9]{3}-[0-9]{3}$" placeholder="XXXXX-XXX">
				</div>

				<label class="control-label col-sm-1" for="logradouro">Logradouro: </label>
				<div class="col-sm-2">
    				<select class="form-control" name="logradouro" id="logradouro">
    					<option value="rua">Rua</option>
    					<option value="avenida">Avenida</option>
    					<option value="praca">Praça</option>
    				</select>
				</div>

				<label class="control-label col-sm-1" for="numero">Numero:</label>
				<div class="col-sm-1">
					<input type="number" class="form-control" name="numero" id="numero" placeholder="Nº">
				</div>

				<label class="control-label col-sm-1" for="bairro">Bairro:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="bairro" id="bairro" pattern="[A-Za-z\s]+$" placeholder="Digite o Bairro">
				</div>
			</div>

			<!-- LINHA6 -->
			<div class="row form-group">
				<label class="control-label col-sm-2" for="complemento">Complemento: </label>
				<div class="col-sm-3">
					<input class="form-control" type="text" name="complemento" id="complemento" pattern="[A-Za-z\s]+$" placeholder="Digite um complemento">
				</div>

				<label class="control-label col-sm-1" for="cidade">Cidade: </label>
				<div class="col-sm-3">
					<input class="form-control" type="text" name="cidade" id="cidade" pattern="[A-Za-z\s]+$" placeholder="Digite uma cidade">
				</div>

				<label class="control-label col-sm-1" for="complemento">Estado: </label>
				<div class="col-sm-2">
					<select class="form-control" name="uf" id="uf">
						<option>AC</option><option>AL</option><option>AP</option><option>AM</option>
                    	<option>BA</option><option>CE</option><option>DF</option><option>ES</option>
                    	<option>GO</option><option>MA</option><option>MT</option><option>MS</option>
                     	<option>MG</option><option>PA</option><option>PB</option><option>PR</option>
                    	<option>PE</option><option>PI</option><option>RJ</option><option>RN</option>
                    	<option>RS</option><option>RO</option><option>RR</option><option>SC</option>
                     	<option>SP</option><option>SE</option><option>TO</option>
					</select>
				</div>
			</div>

			<!-- LINHA7 -->
			<div class="row form-group">
				<fieldset>
				<legend></legend>
				<div class="container col-sm-12" style="background: lightgray; padding: 8px; border-radius: 8px" >
					<table class="col-sm-12" style="margin:0 auto; border-style: none">
						<tr style="text-align: center">
						<td><button type="submit" class="btn-info btn-lg">Salvar</button></td>
						<td><button type="reset" class="btn-info btn-lg">Cancelar</button></td>
						</tr>
					</table>
				</div>
				</fieldset>
			</div>
			</fieldset>
			</form>

			<?php
			 if($_SERVER["REQUEST_METHOD"]=="POST"){
			     if($msgErro == "")
			         echo "<h3 class='text-success'>Cadastro efetuado com SUCESSO!</h3>";
			     else
	                 echo "<h3 class='text-success'>Cadastro NAO efetuado: $msgErro</h3>";
			 }
			?>

		</div>

		<!-- CRIAÇÃO DO RODAPÉ -->
		<?php include "footer.php"?>
	</body>
</html>
