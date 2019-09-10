<?php
	$paginaAtiva = "Galeria";
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
  <style>

   .galeria { width:400px; height: 300px; border-color:lightgray; padding:5px; border-radius: 10px; float:center;}
   th, td {width: 230px;height: 200px;padding: 5px;}

  </style>
  <script>
    function colocaBorda(x) {
      x.border="2";
      x.style.borderColor = "red";
    }

    function tiraBorda(x) {
      x.border="0"
      x.style.borderColor = "transparent";
    }

    $(document).ready(function() {
      $(".galeria").each(function(i) {
        $(this).delay(200*i).fadeIn();
        });
    });
  </script>
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
  <div class="row">
  <table style="text-align:center; margin: 0 auto; padding: 5px 5px;horizontal-align:center">
  <tr style="horizontal-align:center">
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica1.jpg" id="img1"></td>
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica2.jpg" id="img2"></td>
  </tr>
  <tr style="horizontal-align:center">
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica3.jpg" id="img3"></td>
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica4.jpg" id="img4"></td>
  </tr>
  <tr style="horizontal-align:center">
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica5.jpg" id="img5"></td>
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica6.jpg" id="img6"></td>
  </tr>
  <tr style="horizontal-align:center">
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica7.jpg" id="img7"></td>
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica8.jpg" id="img8"></td>
  </tr>
  <tr style="horizontal-align:center">
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)" class="galeria" src="img/clinica9.jpg" id="img9"></td>
    <td><img  onmouseenter="colocaBorda(this)" onmouseleave="tiraBorda(this)"  class="galeria" src="img/clinica10.jpg" id="img10"></td>
  </tr>
  <tr style="horizontal-align:center">
  </td>
  </table>
</div>
</div>

<!-- CRIAÇÃO DO RODAPÉ -->
<?php include "footer.php";?>

</body>
</html>
