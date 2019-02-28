var Agendamento = function(){
	var _self = this;

	
	this.pesquisaExame = function(){
		dialogo({
			"titulo" : "Pesquisa Procedimentos",
			"texto" : $("#DialogPesquisaProcedimento").html(),
			"fnc1" : function(){
				hideModal();
			},
			"fnc2" : function(){
				hideModal()
			},
			"tipo" : "p",
			"largo" : true,
			"ctrl" : true,
			"btn1" : "Inserir Selecionado",
			"icon1" : "check",
			"icon2" : "remove"
		});
		$("#btnFiltrarProcedimentos")
			.click(function(){
				var param = {};
				param.descricao = $("#FFNOMEPROCEDIMENTO").val()
				pesquisaExame.filtraProcedimento( param, function(){
					startOrderTable("#tableExames", true);
				} );
			});
		setTimeout(function(){
			$("#FFNOMEPROCEDIMENTO").focus()
			keyCallClick( "#FFNOMEPROCEDIMENTO", "#btnFiltrarProcedimentos", 13 ); // 13 -> ENTER
			startOrderTable("#tableExames");
		},700);
		startSelect();
	}

	this.excluir = function(a){
		if(document.getElementById("FFCODAGTO").value > 0){
			dialogo({
				"titulo":'Excluir Agendamento',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Agendamento/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODAGTO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Agendamento');
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
	var controle = new Agendamento();	
	pesquisarPaciente = new PesquisarPaciente();
	pesquisaExame = new PesquisaExame();
	

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Agendamento/novo');
	});

	$("#btnLimpar")
		.click(function(){
			
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Agendamento');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
		$("#btnSalvar").attr("disabled", "disabled");	  
		setTimeout(function(){ 
			 $("#btnSalvar").removeAttr("disabled") 		
		 }, 1000);
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
	});

	$("#FFNOMEPROCEDIMENTOTELA")
	.click(function(){
		controle.pesquisaExame();
	});

	$("#btnPesquisaProcedimento")
		.click(function(){
		controle.pesquisaExame();
	});

	$('#FFCPF').mask('000.000.000-00');

	$("#btnExcluirAgendamento")
		.click(function(){
		controle.excluir();
	});





});
