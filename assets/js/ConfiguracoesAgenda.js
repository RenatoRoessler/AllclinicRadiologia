var ConfiguracoesAgenda = function(){
	var _self = this;


	
	

}

$("document").ready(function(){
	var controle = new ConfiguracoesAgenda();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/ConfiguracoesAgenda/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/ConfiguracoesAgenda');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});


});