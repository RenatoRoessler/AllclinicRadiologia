var Eluicao = function(){
	var _self = this;
	var _atvTeoria = 0;

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
					_atvTeoria = 	atividade;			
					//$('#FFATIVIDADETEORICA').val(atividade);
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
		
		if($('#FFCQ').val() == "S"){
			if($('#FFATIVIDADETEORICA').val() == ""){
				mensagem( 'e', 'Informe a Atividade Teórica');
				return false;
			}
			if($('#FFATIVIDADE_MEDIDA').val() == ""){
				mensagem( 'e', 'Informe a Atividade Medida ');
				return false;
			}
			let eficienciaEluicao = $('#FFRESULTADO');
			if(eficienciaEluicao.val() == ""){
				mensagem( 'e', 'Informe o Resultado da Eficiência ');
				return false;
			}
			if($('#FFSUPERIOR').val() == ""){
				mensagem( 'e', 'Informe a parte Superior ');
				return false;
			}
			if($('#FFINFERIOR').val() == ""){
				mensagem( 'e', 'Informe a parte Inferior');
				return false;
			}
			let purezaRadioquimica = $('#FFRADIOQUIMICA');
			if(purezaRadioquimica.val() == ""){
				mensagem( 'e', 'Informe O resultado da Pureza Radioquímica');
				return false;
			}
			if($('#FFATV').val() == ""){
				mensagem( 'e', 'Informe a Atividade');
				return false;
			}
			if($('#FFATVTECNEZIO').val() == ""){
				mensagem( 'e', 'Informe a Atividade de 99m Tc ');
				return false;
			}
			if($('#FFATVFUNDO').val() == ""){
				mensagem( 'e', 'Informe a Atividade de Fundo');
				return false;
			}
			let purezaRadionuclidica = $('#FFRADIONUCLIDICA')
			if(purezaRadionuclidica.val() == ""){
				mensagem( 'e', 'Informe o Resultado da Pureza Radionuclídica ');
				return false;
			}
			if($('#FFPH').val() == ""){
				mensagem( 'e', 'Informe o PH');
				return false;
			}
			
			let eficienciaEluicaoVal = eficienciaEluicao.val();
			eficienciaEluicaoVal = apenasNumeroPontoVirgula(eficienciaEluicaoVal);

			if(eficienciaEluicaoVal > 95){
				mensagem( 'e', 'Eficiência da Eluição Maior que 95% ');
				return false;
			}				
			if(eficienciaEluicaoVal <= 0 ){
				mensagem( 'e', 'Eficiência da Eluição igual a 0 ' );
				return false;
			}

			let purezaRadioquimicaVal = purezaRadioquimica.val();
			purezaRadioquimicaVal = apenasNumeroPontoVirgula(purezaRadioquimicaVal);
			if(purezaRadioquimicaVal < 95){
				mensagem( 'e', 'Pureza Quimica Menor que 95% ');
				return false;
			}				
			if(purezaRadioquimicaVal <= 0 ){
				mensagem( 'e', 'Pureza Quimica igual a 0 ' );
				return false;
			}
			let purezaRadionuclidicaVal =  purezaRadionuclidica.val();
			purezaRadionuclidicaVal = apenasNumeroPontoVirgula(purezaRadionuclidicaVal);
			if(purezaRadionuclidicaVal > 0.15){
				mensagem( 'e', 'Pureza Radionuclídica Maior que 0.15 ');
				return false;
			}				
			if(purezaRadionuclidicaVal <= 0 ){
				mensagem( 'e', ' Não é Permitido Pureza Radionuclídica igual a 0 ' );
				return false;
			}			
		}
		$("#formularioCadastro").submit();
	}
	this.calcEficiencia = function (a){
		let teorica = parseFloat($('#FFATIVIDADETEORICA').val());
		let medida = parseFloat($('#FFATIVIDADE_MEDIDA').val());
		if(teorica > 0 && medida > 0){
			let resultado =  ( 100 * medida) / teorica;
			$('#FFRESULTADO').val(resultado.toFixed(2) +'%')  ;
		}else{
			$('#FFRESULTADO').val("0") ;
		}
	};

	this.calcPurezaRadioquimica = function(a) {
		let superior =  parseFloat($('#FFSUPERIOR').val());
		let inferior =  parseFloat($('#FFINFERIOR').val());

		if(superior > 0 && inferior > 0){
			let resultado = superior / (superior + inferior )
			resultado = resultado  * 100;
			if(resultado > 95){
				$('#FFRADIOQUIMICA').val(resultado.toFixed(2) +'% Aprovado')  ;	
				$('#FFRADIOQUIMICA').css("color","green");
			}else{
				$('#FFRADIOQUIMICA').val(resultado.toFixed(2) +'% Reprovado')  ;
				$('#FFRADIOQUIMICA').css("color","red");	
			}
		}else{
			$('#FFRADIOQUIMICA').val("0")  ;	
			$('#FFRADIOQUIMICA').css("color","black");
		}
	}

	this.calcPurezaRadionuclidica = function() {
		let bg =  parseFloat($('#FFATVFUNDO').val());
		let b = parseFloat($('#FFATV').val());
		let c = parseFloat($('#FFATVTECNEZIO').val());
		if(bg > 0 && b > 0 && c > 0 ){
			let y, z, a = 0;
			y = b - bg;
			z = y * 3.4;
			a = z / c; 			
			if(a > 0.15){
				$('#FFRADIONUCLIDICA').val( a.toFixed(2) + ' Reprovado' );
				$('#FFRADIONUCLIDICA').css("color","red");
			}else {
				$('#FFRADIONUCLIDICA').val( a.toFixed(2) + ' Aprovado' );
				$('#FFRADIONUCLIDICA').css("color","green");
			}			
		}
	}

	this.atividadeTeorica = function(){
		let nroEluicao = 1;
		let atvMO =  0.01050223;
		let tempo =  24;
		let resultado = 0;
		let exponencial  = -atvMO * tempo;
		resultado = Math.pow( 2.71, exponencial);
		resultado = _atvTeoria * resultado;
		$('#FFATIVIDADETEORICA').val(resultado.toFixed(2));
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
		controle.salvar();
		//$("#formularioCadastro").submit();
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
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
		//controle.calcEficiencia();
		controle.atividadeTeorica();

	});

	$("#btnExcluirEluicao")
	.click(function(){
		controle.excluir();
	});

	$("#FFATIVIDADE_MEDIDA")
	.blur(function(){
		controle.calcEficiencia();
	});

	$("#FFINFERIOR")
	.blur(function(){
		controle.calcPurezaRadioquimica();
	});

	$("#FFSUPERIOR")
	.blur(function(){
		controle.calcPurezaRadioquimica();
	});

	$("#FFATV")
	.blur(function(){
		controle.calcPurezaRadionuclidica();
	});
	$("#FFATVTECNEZIO")
	.blur(function(){
		controle.calcPurezaRadionuclidica();
	});
	$("#FFATVFUNDO")
	.blur(function(){
		controle.calcPurezaRadionuclidica();
	});

	controle.calcPurezaRadioquimica();
	controle.calcEficiencia();
	controle.calcPurezaRadionuclidica();

});