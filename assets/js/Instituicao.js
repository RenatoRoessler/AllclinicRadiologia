var Instituicao = function(){
	var _self = this;


	this.funcao1 = function(){
		//alert("Eu sou um alert!");
		mensagem( 's', 'teste' );
	}		

}

$("document").ready(function(){
	var controle = new Instituicao();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Instituicao/novo');
	});	
	$("#btnSalvar")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Instituicao');
	});	


});