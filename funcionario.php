<?php

class DadosFuncionario{
    public $nome;
    public $cargo;
    public $sexo;
    public $rg;
    public $logradouro;
    public $cidade;

}

function getDadosFuncionario($conn){
    $arrayDadosFuncionarios = "";

    $SQL = "
            SELECT Nome AS Funcionario,
                   Cargo AS Funcionario,
                   Sexo AS Funcionario,
                   RG AS Funcionario
                   Logradouro AS EnderecoFunc,
                   Cidade AS EnderecoFunc
            FROM Funcionario f, EnderecoFunc e
            WHERE f.Nome_ID = e.Nome_ID
          ";
    $stmt = $conn->prepare($SQL);

    echo "<h4>Entrou</h4>";
    $stmt->execute();

    $stmt->bind_result($nome,$cargo,$sexo,$rg,$logradouro,$cidade);

    while($stmt->fetch()){
        $dados = new DadosFuncionario();

        $dados->nome                  = $row["Nome"];
        $dados->cargo                 = $row["Cargo"];
        $dados->sexo                  = $row["Sexo"];
        $dados->rg                    = $row["RG"];
        $dados->logradouro            = $row["Logradouro"];
        $dados->cidade                = $row["Cidade"];

        $arrayDadosFuncionarios[] = $dados;
    }
  return $arrayDadosFuncionarios;
}
?>
