var Marcacao = function(){
	var _self = this;

	

}

$("document").ready(function(){
	var controle = new Marcacao();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/Allclinic/Marcacao/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/Allclinic/Marcacao/Index');
	});	
	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
		});
	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});	

	$('#FFDATAHORA').datepicker({	
			format: "dd/mm/yyyy",	
			language: "pt-BR",
			autoclose: true
		});
		

});