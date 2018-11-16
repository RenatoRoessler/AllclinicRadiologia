var Fracionamento = function(){
	var _self = this;

	this.adicionar = function(a){

		if(document.getElementById("FFMARCACAO").selectedIndex == ""){
			mensagem( 'e', 'Selecione a Marcação');
			document.getElementById("FFMARCACAO").focus();
			return false;
		}
		if(document.getElementById("FFAGENDAMENTO").value == ""){
			mensagem( 'e', 'Selecione o Agendamento');
			return false;
		}

		$.ajax({
			url : '/AllclinicRadiologia/Fracionamento/adicionar/',
			type : 'POST',
			timeout: 30000,
			data : {
				'Codigo' :  '1',
				'CODMARCACAO' : $('#FFMARCACAO').val(),
				'CODFRACIONAMENTO' : $('#FFCODFRACIONAMENTO').val(),
				'CODAGTOEXA' : $('#FFCODAGTOEXA1').val(),
				'ATIVIDADE' : $('#FFATIVIDADE').val() > 0 ? $('#FFATIVIDADE').val() : 0,
			},
			beforeSend: function(){
				loader('show');
			},
			success: function( retorno ){
				var j = jsonEncode( retorno, 'json' );
				mensagem(j.content.tipoMsg , j.content.Mensagem);
				let codigo = j.content.codfracionamento;
				loader('hide');
				ir('/AllclinicRadiologia/Fracionamento/editar/' +  codigo);
			},
			error: function( request, status, error ){ 
				loader('hide');
				mensagem( 'e', error )
			}
		});		
	}

	this.pesquisaAgendamento = function(){
		dialogo({
			"titulo" : "Pesquisa Agendamento",
			"texto" : $("#DialogPesquisaAgendamento").html(),
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
		//$("#btnDialogoS1").prop("disabled",true);
		$("#btnFiltrarAgendamentos")
			.click(function(){
				var param = {};
				param.nome = $("#FFNOMEPAC").val()
				param.data = $("#FFDATAHORAFILTRO").val()
				pesquisaAgendamento.filtraAgendamento( param, function(){
					startOrderTable("#tableAgendamentos", true);
				} );
			});
		setTimeout(function(){
			$("#FFNOMEPAC").focus()
			keyCallClick( "#FFNOMEPAC", "#btnFiltrarAgendamentos", 13 ); // 13 -> ENTER
			startOrderTable("#tableAgendamentos");
		},700);
		startSelect();
	}
}

$("document").ready(function(){
	var controle = new Fracionamento();
	pesquisarPaciente = new PesquisarPaciente();
	pesquisaAgendamento = new PesquisaAgendamento();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$("#btnAdicionar")
	.click(function(){
		controle.adicionar();
	});

	$("#btnSalvarAdministracao")
	.click(function(){
		$("#formularioAdministrar").submit();
	});
	$("#btnVoltarAdministracao")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento/editar/' + $('#FFCODFRACIONAMENTO1').val() );
	});	

	$("#btnAgendamento")
	.click(function(){
		controle.pesquisaAgendamento();
	});
	$("#FFAGENDAMENTO")
	.click(function(){
		controle.pesquisaAgendamento();
	});	

	startTooltip();

});