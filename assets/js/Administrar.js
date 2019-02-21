var Administrar = function(){
	var _self = this;

	this.calcAtivadadeAdministrada = function(){
		let horaInicio = $('#FFHORAINICIO').val();
		let horaAdministrada = $('#FFHORAADMINISTRADA').val();
		let horaIni = horaInicio.split(':'); 
		let horaSom = horaAdministrada.split(':'); 
		let diferencaEmHoras = horaSom[0] - horaIni[0];
		let diferencaEmMinutos = horaSom[1] - horaIni[1];
		let diferenca =   diferencaEmHoras + '.' +  ((diferencaEmMinutos/60)*100 ).toFixed();
		let resultado =  horaIni[0] + '.' + ((horaIni[1]/60)*100 );
		resultado = resultado * Math.pow(2.71 , (- 0.11533231 * diferenca ));
		$('#FFATVADMINISTRADA').val(resultado.toFixed(2));
	}
}

$("document").ready(function(){
	var controle = new Administrar();


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
			//$('#btnSearch').trigger('click')
	});	
	

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Fracionamento');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$("#btnSalvarAdministracao")
	.click(function(){
		$("#formularioAdministrar").submit();
	});
	$("#btnVoltarAdministracao")
	.click(function(){
		ir('/AllclinicRadiologia/Administrar');
	});	

	$("#btnAgendamento")
	.click(function(){
		controle.pesquisaAgendamento();
	});
	$("#FFAGENDAMENTO")
	.click(function(){
		controle.pesquisaAgendamento();
	});	

	$(document).ready(function(){
		$("#sidenavToggler").click();
		});
	
	$('#FFHORAADMINISTRADA').change(function() {
		controle.calcAtivadadeAdministrada();
	});
	$('#FFHORAINICIO').change(function() {
		controle.calcAtivadadeAdministrada();
	});
		
		controle.calcAtivadadeAdministrada();

});