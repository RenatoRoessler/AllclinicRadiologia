var Marcacao = function(){
	var _self = this;

	this.gerarLote = function(){
		let codeluicao = document.getElementById("FFELUICAO").value;
		let codmarcaco = document.getElementById("FFCODMARCACAO").value;
		if(codeluicao > 0){
			$.ajax({
				url : '/AllclinicRadiologia/Marcacao/gerarLoteMarcacao/',
				type : 'POST',
				timeout: 30000,
				data : {
					'codeluicao' : codeluicao,
					'codmarcacao' : codmarcaco,
				},
				beforeSend: function(){
					loader('show');
				},
				success: function( retorno ){
					var j = jsonEncode( retorno, 'json' );	
					var lote = 	j.content.lote;			
					$("#FFLOTE").val("M" + j.content.lote );	
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
	}
	
	this.salvar = function(){
		if(document.getElementById("FFFARMACO").selectedIndex == ""){
			mensagem( 'e', 'Selecione o Farmaco');
			return false;
		}
		$("#formularioCadastro").submit();
	}

	this.excluir = function(a){
		if(document.getElementById("FFCODMARCACAO").value > 0){
			dialogo({
				"titulo":'Excluir Maracação',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Marcacao/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODMARCACAO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Marcacao');
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
}

$("document").ready(function(){
	var controle = new Marcacao();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Marcacao/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Marcacao/Index');
	});	
	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
		});
	$("#btnSalvar")
	.click(function(){
		controle.salvar();
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
	
	$("#FFELUICAO")
	.change(function(){
		controle.gerarLote();
	});

	$("#FFKITFABRICANTE")
		.change(function(){
			selectFill( $('#FFKITFABRICANTE'), function(){ startSelect('refresh') } );
		});	
		
		$("#btnExcluirMarcacao")
		.click(function(){
			controle.excluir();
		});

});