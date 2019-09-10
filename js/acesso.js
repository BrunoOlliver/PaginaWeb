    funtion buscaAcesso(user,password){
      $.ajax({
        url: "consulta-acesso.php",
        type: "POST",
        async: true,
        dataType: "json",
        data: {"user":user,"password":password},
        success: function(result){
          if(result != ""){
            $(document).ready(function(){
              $("#navbar-restrito").show(),
              $("#navbar").hide();
            });
          }
        },
        error: function(xhr, status, error) {
          alert(status + error + xhr.responseText);
        }
      });
    }
