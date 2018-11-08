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
		ir('/Allclinic/Usuarios/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/Allclinic/Usuarios/Index');
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

		

});