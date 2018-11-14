var Agendamento = function(){
	var _self = this;

	this.pesquisarPaciente = function(){
		dialogo({
			"titulo" : "Pesquisa Paciente",
			"texto" : $("#DialogLaudoPadrao").html(),
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
		$("#btnFiltraLaudoPadrao")
			.click(function(){
				var param = {};
				param.cpf = $("#FFFiltroCPF").val()
				param.nome = $("#NomeTextoPadrao").val()
				param.prontuario = $("#FFFiltroPRONTUARIO").val()
				pesquisarPaciente.filtraTextoPadrao( param, function(){
					startOrderTable("#tableTextoPadrao", true);
				} );
			});
		setTimeout(function(){
			$("#NomeTextoPadrao").focus()
			keyCallClick( "#NomeTextoPadrao", "#btnFiltraLaudoPadrao", 13 ); // 13 -> ENTER
			keyCallClick( "#FFFiltroPRONTUARIO", "#btnFiltraLaudoPadrao", 13 ); // 13 -> ENTER
			keyCallClick( "#FFFiltroCPF", "#btnFiltraLaudoPadrao", 13 ); // 13 -> ENTER
			startOrderTable("#tableTextoPadrao");
		},700);
		startSelect();
	}
	
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
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
	});

	$('#FFDATAHORA').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
	});
	$("#FFNOMEPAC")
			.click(function(){
				controle.pesquisarPaciente();
	});

	$("#btnPesquisaPac")
			.click(function(){
				controle.pesquisarPaciente();
	});

	$("#FFNOMEPROCEDIMENTOTELA")
	.click(function(){
		controle.pesquisaExame();
	});

	$("#btnPesquisaProcedimento")
		.click(function(){
		controle.pesquisaExame();
	});

	$('#Data').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
});


});