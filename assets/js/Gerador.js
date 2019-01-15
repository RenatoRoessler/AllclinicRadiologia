var Gerador = function(){
	var _self = this;
	

	this.excluir = function(a){
		var id = $("#tableIndex tbody tr.bg-lightgray").attr('id');
		dialogo({
			'titulo':'Salvar',
			'texto':'Ol&aacute;,<br/>deseja salvar registro ?' + $("#tableIndex tbody tr.bg-lightgray").attr('id'),
			'fnc1':function(){
				//$("#Mensagem").val(content) ;
			},
			'tipo':'p',
			'btn1':'Salvar',
			'btn2':'Cancelar'
		});

	}	

}

$("document").ready(function(){
	var controle = new Gerador();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Gerador/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Gerador');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$('#FFDATAHORA2').datetimepicker({
                    locale: 'pt',
                    format: "dd/mm/yyyy hh:i",
                    language: "pt-BR"

    });

	$('#FFDATAPESQUISA').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});
	$('#FFDATAFINALPESQUISA').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});



});