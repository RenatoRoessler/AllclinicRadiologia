var Marcacao = function(){
	var _self = this;
	var ph_superior;
	var ph_inferior;
	var solv_organico;
	var solv_inorganico;



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

	this.getDadosFarmaco = function (){
		let codfarmaco = $("#FFFARMACO").val();
		if(codfarmaco > 0){
			$.ajax({
				url : '/AllclinicRadiologia/farmaco/getLimitesFarmaco/',
				type : 'POST',
				timeout: 30000,
				data : {
					'codfarmaco' : codfarmaco,
					},
				beforeSend: function(){
					loader('show');
				},
				success: function( retorno ){
					var j = jsonEncode( retorno, 'json' );	
					ph_superior = j.content.ph_superior;
					ph_inferior = j.content.ph_inferior;
					solv_organico = j.content.solv_organico;
					solv_inorganico = j.content.solv_inorganico; 
					escreverLimites()
					loader('hide');						
				},
				error: function( request, status, error ){ 
					ph_superior = 0;
					ph_inferior = 0;
					solv_organico = 0;
					solv_inorganico = 0;
					escreverLimites()
					loader('hide');
					mensagem( 'e', error )
				}
			});

		}else{
			ph_superior = 0;
			ph_inferior = 0;
			solv_organico = 0;
			solv_inorganico = 0; 	
		}
	}

	function escreverLimites() {
		document.getElementById('phHelp').innerHTML = 'o valor deve ser maior ' + ph_inferior + ' e menor que ' + ph_superior;
		document.getElementById('organicoHelp').innerHTML = 'o valor deve ser maior ' + solv_organico;
		document.getElementById('inorganicoHelp').innerHTML = 'o valor deve ser maior ' + solv_inorganico;
		
	}

	function marcacaoAprovada(){
		let aprovado = true;
		let inorganico = $("#FFINORGANICO").val();
		if(inorganico <= solv_inorganico){
			console.log('reprovado por solv_inorganico')
			aprovado =  false;
		}
		let organico = $("#FFORGANICO").val();
		if(organico <= solv_organico){
			console.log('reprovado por solv_organico')
			aprovado =  false;
		}
		let ph = $("#FFPH").val();
		if(ph < ph_inferior || ph > ph_superior){
			console.log('reprovado por ph')
			aprovado =  false;
		}
		let campoAprovado = $("#FFAPROVADODESC");
		let campoAprovadoTable = $("#FFAPROVADO");
		if(aprovado) {			
			campoAprovadoTable.val('S');
			campoAprovado.val('Aprovado');
		}else{
			campoAprovado.val('N');
			campoAprovado.val('Reprovado');
		}
		return true;
	}
	
	this.salvar = function(){
		
		if($("#FFELUICAO").val() == ""){
			mensagem( 'e', 'Selecione a Eluição');
			return false;
		}
		if($("#FFFARMACO").val() == ""){
			mensagem( 'e', 'Selecione o Farmaco');
			return false;
		}
		marcacaoAprovada();

		

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


	this.calcEficiencia = function(superior, inferior , campo) {

		if(superior > 0 && inferior > 0){
			let resultado = superior / (superior + inferior )
			resultado = resultado  * 100;
			campo.val(resultado.toFixed(2))  ;	
		}else{
			campo.val("0")  ;	
		}
	}
	
	this.calcMedia = function() {
		let m1 = parseFloat($("#FFORGANICO").val());
		let m2 = parseFloat($("#FFINORGANICO").val());
		let resultado =0;

		if(m1 > 0 && m2 > 0){
			resultado = ((m1 + m2) / 2);
		}else if(m1 > 0 && m2 <= 0){
			resultado = m1;
		}else if(m1 <= 0 && m2 > 0){
			resultado = m2;
		}
		$("#FFMEDIA").val(resultado.toFixed(2));
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

	$('#FFDATAPESQUISA').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});	
	
	$("#FFELUICAO")
	.change(function(){
		controle.gerarLote();
	});
	$('#FFDATAFINAL').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});	

	$("#FFKITFABRICANTE")
		.change(function(){
			selectFill( $('#FFKITFABRICANTE'), function(){ startSelect('refresh') } );
	});	
		
	$("#btnExcluirMarcacao")
		.click(function(){
			controle.excluir();
	});
	$("#FFORGANICOSUPERIOR").change(function(){
		let superior = parseFloat($("#FFORGANICOSUPERIOR").val());
		let inferior = parseFloat($("#FFORGANICOINFERIOR").val());
		controle.calcEficiencia(superior, inferior  ,$("#FFORGANICO"));
		controle.calcMedia();
	});
	$("#FFORGANICOINFERIOR").change(function(){
		let superior = parseFloat($("#FFORGANICOSUPERIOR").val());
		let inferior = parseFloat($("#FFORGANICOINFERIOR").val());
		controle.calcEficiencia(superior, inferior  ,$("#FFORGANICO"));
		controle.calcMedia();
	});
	$("#FFINORGANICOSUPERIOR").change(function(){
		let superior = parseFloat($("#FFINORGANICOSUPERIOR").val());
		let inferior = parseFloat($("#FFINORGANICOINFERIOR").val());
		controle.calcEficiencia(superior, inferior  ,$("#FFINORGANICO"));
		controle.calcMedia();
	});
	$("#FFINORGANICOINFERIOR").change(function(){
		let superior = parseFloat($("#FFINORGANICOSUPERIOR").val());
		let inferior = parseFloat($("#FFINORGANICOINFERIOR").val());
		controle.calcEficiencia(superior, inferior  ,$("#FFINORGANICO"));
		controle.calcMedia();
	});
	$('#FFFARMACO').change(function(a) {
		controle.getDadosFarmaco();
	});

	controle.getDadosFarmaco();



});