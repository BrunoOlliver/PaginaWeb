$(document).ready(function(){
  $("#opcaoSelect").click(function(){
     var valor = $('#opcaoSelect option:selected').text();

   if(valor == "Médico"){
     $("#label-especialidade").slideToggle(200).show();
     $("#lista-especialidade").slideToggle(200).show();
   }else{
     $("#label-especialidade").hide();
     $("#lista-especialidade").hide();
   }
  });
});
$('#opcaoSelect').click(function(i){
  $getJSON('especialidades.php?opcao=especialidade',function(dados){
    if(dados.length > 0){
      var option = '<option>Selecione a especialidade</option>';
      $.each(dados,function(i,obj){
        option += '<option value= "'+obj.Especialidade_ID+'">'+obj.Descricao+'</option>';
      })
    }else {
      Reset();
    }
  })
});

function Reset(){
  $('#especialidade').empty().append('<option>Selecione a especialidade</option>');
}
