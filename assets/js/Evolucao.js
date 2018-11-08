var Evolucao = function(){
	var _self = this;

	


}

$("document").ready(function(){
	var controle = new Evolucao();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Evolucao/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Evolucao');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
	});

	$('#FFDATAINCIAL').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
			});
	$('#FFDATAFINAL').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
			});
});