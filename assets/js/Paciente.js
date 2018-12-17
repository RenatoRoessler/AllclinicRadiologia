var Paciente = function(){
	var _self = this;

	this.excluir = function(a){
		if(document.getElementById("FFPRONTUARIO").value > 0){
			dialogo({
				"titulo":'Excluir Paciente',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Paciente/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFPRONTUARIO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Paciente');
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
	var controle = new Paciente();

	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Paciente/novo');
	});
	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Paciente/Index');
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

	$("#btnExcluirPaciente")
	.click(function(){
		controle.excluir();
	});
		

});