var Farmaco = function(){
	var _self = this;

	this.excluir = function(a){
		if(document.getElementById("FFCODFARMACO").value > 0){
			dialogo({
				"titulo":'Excluir',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Farmaco/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODFARMACO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Farmaco');
							}							
						},
						error: function( request, status, error ){ 
							loader('hide');
							mensagem( 'e', error )
						}
					});
				},
				"tipo":'p',
				"b1":'Confirmar',
				"b2":'Cancelar' 
			});
		}
	}

	this.adicionar = function(a){

		if(document.getElementById("FFCODFARMACO").value == ""){
			mensagem( 'e', 'Salve o Farmaco Primeiro');
			return false;

		}		
		if(document.getElementById("FFFABRICANTE").selectedIndex == ""){
			mensagem( 'e', 'Selecione o Farmaco');
			return false;
		}
		let codfarmaco  = $('#FFCODFARMACO').val() 
		$.ajax({
			url : '/AllclinicRadiologia/farmaco/vincular/',
			type : 'POST',
			timeout: 30000,
			data : {
				'Codigo' :  '1',
				'CODFABRICANTE' : $('#FFFABRICANTE').val(),
				'CODFARMACO' : codfarmaco,				
			},
			beforeSend: function(){
				loader('show');
			},
			success: function( retorno ){
				var j = jsonEncode( retorno, 'json' );
				mensagem(j.content.tipoMsg , j.content.Mensagem);	
				if(j.content.tipoMsg == 's'){
					ir('/AllclinicRadiologia/farmaco/editar/' +  codfarmaco);
				}
				loader('hide');	
			},
			error: function( request, status, error ){ 
				loader('hide');
				mensagem( 'e', error )
			}
		});	
	}
	
}

$("document").ready(function(){
	var controle = new Farmaco();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Farmaco/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Farmaco');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$("#btnExcluirFarmaco")
	.click(function(){
		controle.excluir();
	});

	$("#btnAdicionar")
	.click(function(){
		controle.adicionar();
	});


});