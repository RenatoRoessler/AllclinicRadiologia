var Fracionamento = function(){
	var _self = this;

	this.adicionar = function(a){

		if(document.getElementById("FFMARCACAO").selectedIndex == ""){
			mensagem( 'e', 'Selecione a Marcação');
			document.getElementById("FFMARCACAO").focus();
			return false;
		}
		if(document.getElementById("FFPRONTUARIO").value == ""){
			mensagem( 'e', 'Selecione o Paciente');
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
				'PRONTUARIO' : $('#FFPRONTUARIO').val(),
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


	this.pesquisarPaciente = function(){
		dialogo({
			"titulo" : "Pesquisa Paciente",
			"texto" : $("#DialogLaudoPadrao").html(),
			"fnc1" : function(){
				/*
				var line = $("#tableTextoPadrao .bg-lightgray");
				if( $('#FFFILTRO') ){
					//$('#FFATIVIDADE').val() = $('#FFFILTRO');
					document.getElementById('FFATIVIDADE').value = line.data("prontuario") ;
				}else{
					document.getElementById('FFATIVIDADE').clear;	
				}
				*/
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
}

$("document").ready(function(){
	var controle = new Fracionamento();
	pesquisarPaciente = new PesquisarPaciente();

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

	$("#btnTeste")
	.click(function(){
		controle.pesquisarPaciente();
	});
	$("#FFNOMEPAC")
	.click(function(){
		controle.pesquisarPaciente();
	});

	startTooltip();



});