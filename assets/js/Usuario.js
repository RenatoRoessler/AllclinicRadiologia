var Usuario = function(){
	var _self = this;

	

}

$("document").ready(function(){
	var controle = new Usuario();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Usuarios/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Usuarios/Index');
	});	
	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$("select").prop('selectedIndex',0);
			$('#btnSearch').trigger('click')
		});
	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});	

		

});