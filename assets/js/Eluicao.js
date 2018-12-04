var Eluicao = function(){
	var _self = this;

	this.teste = function(){
		let codgeardor = document.getElementById("FFGERADOR").value;
		if(codgeardor > 0){
			$.ajax({
				url : '/AllclinicRadiologia/Eluicao/gerarLoteEluicao/',
				type : 'POST',
				timeout: 30000,
				data : {
					'codgerador' : codgeardor,
				},
				beforeSend: function(){
					loader('show');
				},
				success: function( retorno ){
					var j = jsonEncode( retorno, 'json' );	
					var lote = 	j.content.lote;			
					$("#FFLOTE").val("E" + j.content.lote );	
					loader('hide');						
				},
				error: function( request, status, error ){ 
					loader('hide');
					mensagem( 'e', error )
				}
			});
		}else{
			document.getElementById("FFLOTE").value = "";	
		}
		//console.log('teste');
		//console.log(lote)
		
	}
	


}

$("document").ready(function(){
	var controle = new Eluicao();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Eluicao/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Eluicao');
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
	$('#FFDATAPESQUISA').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
	});	
	
	$("#FFGERADOR")
	.change(function(){
		controle.teste();
	});




});