var Agendamento = function(){
	var _self = this;

	


}

$("document").ready(function(){
	var controle = new Agendamento();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Agendamento/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Agendamento');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
	});

	$('#FFDATAHORA').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
			});


});