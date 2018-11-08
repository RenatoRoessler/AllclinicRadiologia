var Paciente = function(){
	var _self = this;

	

}

$("document").ready(function(){
	var controle = new Paciente();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/Allclinic/Paciente/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/Allclinic/Paciente/Index');
	});	
	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
		});
	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});	

	$('#FFCPF').mask('000.000.000-00');
	$('#FFTELEFONE').mask('(00)00000-0000');
	//$('#FFPESO').mask('000.000',{reverse: true});
	//$('#FFALTURA').mask('0.000');

	$('#FFDTNASC').datepicker({	
		format: "dd/mm/yyyy",	
		language: "pt-BR",
		autoclose: true
	});
		

});