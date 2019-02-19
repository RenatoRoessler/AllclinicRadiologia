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

	this.atividade99mo = function(a){
		let atividade = $('#FFATIVIDADECAL').val();
		let atividade99mo1 = $('#FFATIVIDADEMO99');
		if(atividade == 2000){
			atividade99mo1.val(2400);
		}
		if(atividade == 1500){
			atividade99mo1.val(1800);
		}
		if(atividade == 1250){
			atividade99mo1.val(1500);			
		}
		if(atividade == 1000){
			atividade99mo1.val(1200);			
		}
		if(atividade == 750){
			atividade99mo1.val(900);			
		}
		if(atividade == 500){
			atividade99mo1.val(600);			
		}
		if(atividade == 250){
			atividade99mo1.val(300);			
		}
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
	$('#FFATIVIDADECAL').change(function(){
		controle.atividade99mo()
	});

});