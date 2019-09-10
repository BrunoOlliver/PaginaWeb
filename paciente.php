<?php

class DadosPaciente{
    public $codigo;
	public $nome;
	public $mail;
    public $fone;
	public $cel;
    
}
    
function getDadosPaciente($conn){
    $arrayDadosPacientes = "";
    
    $SQL = "SELECT * FROM Paciente";
     
    $stmt = $conn->prepare($SQL);
    
    $stmt->execute();
    
    $stmt->bind_result($codigo,$nome,$mail,$fone,$cel);
        while($stmt->fetch()){
            $dados = new DadosPaciente();
            
			$dados->codigo				  = $row["Codigo"];
            $dados->nome                  = $row["Nome"];
			$dados->mail				  = $row["E-Mail"]
            $dados->fone                  = $row["Telefone"];
            $dados->cel                   = $row["Celular"];
            
            $arrayDadosPacientes[] = $dados;
        }
    
    return $arrayDadosPacientes;
}
?>


