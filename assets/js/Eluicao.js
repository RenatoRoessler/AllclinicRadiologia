var Eluicao = function(){
	var _self = this;

	this.gerarLote = function(){
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
					var atividade = j.content.atividade;
					$('#FFATIVIDADETEORICA').val(atividade);
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

	this.excluir = function(a){
		if(document.getElementById("FFCODELUICAO").value > 0){
			dialogo({
				"titulo":'Excluir Eluição',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Eluicao/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODELUICAO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Eluicao');
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

	this.salvar = function(){
		if($('#FFGERADOR').val() == ""){
			mensagem( 'e', 'Selecione um Gerador');
			return false;
		}
		if($('#FFDATAHORA').val() == ""){
			mensagem( 'e', 'Informe a data');
			return false;
		}
		if($('#FFHORA').val() == ""){
			mensagem( 'e', 'Informe a Hora');
			return false;
		}
		if($('#FFVOLUME').val() == ""){
			mensagem( 'e', 'Informe o Volume');
			return false;
		}
		if($('#FFATIVIDADE_MCI').val() == ""){
			mensagem( 'e', 'Informe a Atividade');
			return false;
		}		
		$("#formularioCadastro").submit();
	}
	this.calcEficiencia = function (a){
		let teorica = $('#FFATIVIDADETEORICA').val();
		let medida = $('#FFATIVIDADE_MEDIDA').val();
		if(teorica > 0 && medida > 0){
			resultado =  ( 100 * medida) / teorica;
			$('#FFRESULTADO').val(resultado.toFixed(2) +'%')  ;
		}
	};



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
		controle.salvar();
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
	$('#FFDATAFINAL').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});	
	
	$("#FFGERADOR")
	.change(function(){
		controle.gerarLote();
	});

	$("#btnExcluirEluicao")
	.click(function(){
		controle.excluir();
	});

	$("#FFATIVIDADE_MEDIDA")
	.blur(function(){
		controle.calcEficiencia();
	});




});