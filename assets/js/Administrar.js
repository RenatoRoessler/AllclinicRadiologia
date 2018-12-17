var Administrar = function(){
	var _self = this;



}

$("document").ready(function(){
	var controle = new Administrar();


	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$("#btnSalvarAdministracao")
	.click(function(){
		$("#formularioAdministrar").submit();
	});
	$("#btnVoltarAdministracao")
	.click(function(){
		ir('/AllclinicRadiologia/Administrar');
	});	

	$("#btnAgendamento")
	.click(function(){
		controle.pesquisaAgendamento();
	});
	$("#FFAGENDAMENTO")
	.click(function(){
		controle.pesquisaAgendamento();
	});	

	$('#FFDATAPESQUISA').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});	
	$('#FFDATAFINALPESQUISA').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});	
	$(document).ready(function(){
		$("#sidenavToggler").click();
   });

	startTooltip();

});