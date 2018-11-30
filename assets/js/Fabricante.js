var Fabricante = function(){
	var _self = this;

	this.adicionar = function(a){

		if(document.getElementById("FFCODFABRICANTE").value == ""){
			mensagem( 'e', 'Salve o Fabricante Primeiro');
			return false;

		}		
		if(document.getElementById("FFFARMACO").selectedIndex == ""){
			mensagem( 'e', 'Selecione o Farmaco');
			return false;
		}
		$.ajax({
			url : '/AllclinicRadiologia/fabricante/vincular/',
			type : 'POST',
			timeout: 30000,
			data : {
				'Codigo' :  '1',
				'CODFARMACO' : $('#FFFARMACO').val(),
				'CODFABRICANTE' : $('#FFCODFABRICANTE').val(),
				
			},
			beforeSend: function(){
				loader('show');
			},
			success: function( retorno ){
				var j = jsonEncode( retorno, 'json' );
				mensagem(j.content.tipoMsg , j.content.Mensagem);
				let codigo = j.content.codfabricante;
				loader('hide');
				ir('/AllclinicRadiologia/fabricante/editar/' +  codigo);
			},
			error: function( request, status, error ){ 
				loader('hide');
				mensagem( 'e', error )
			}
		});	
	
	}

}

$("document").ready(function(){
	var controle = new Fabricante();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Fabricante/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Fabricante');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});
	$("#btnAdicionar")
	.click(function(){
		controle.adicionar();
	});

});