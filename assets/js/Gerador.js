var Gerador = function(){
	var _self = this;


 
	

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
	$('#FFDATAHORA').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
			});
	$('#FFDATAHORA2').datetimepicker({
                    locale: 'pt',
                    format: "dd/mm/yyyy hh:i",
                    language: "pt-BR"

    });
    $('#FFDATACALIBRACAO').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				autoclose: true
			});


});