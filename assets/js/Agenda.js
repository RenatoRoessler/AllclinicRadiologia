var Agenda = function(){
	var _self = this;

	this.Filtrar = function(){
		//var content = htmlConvertToDB( tinyMCE.activeEditor.getContent({format : 'html'}));

		if(document.getElementById("FFAGENDA").selectedIndex == ""){
			alert('Infrome a Agenda');
			return false;
		}
		if(document.getElementById("datafiltro").value == ""){
			alert('Informe a Data');
			return false;
		}
    	$("#formulario").submit();			

	}	

}

$("document").ready(function(){
	var controle = new Agenda();

	$("#btnSearch")
	.click(function(){
		controle.Filtrar();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/Allclinic/ConfiguracoesAgenda/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	

	$("#btnVoltar")
	.click(function(){
		ir('/Allclinic/ConfiguracoesAgenda');
	});		

	$("#btnSalvar")
	.click(function(){
		$("#formularioCadastro").submit();
	});

	$(document).ready(function(){
 		$("#sidenavToggler").click();
	});
	/*

	$(function() {
		$('#sandbox-container').datepicker({
    		format: "dd/mm/yyyy",
    		language: "pt-BR"
		});
		$('#sandbox-container').on('dp.change', function(event) {
			$('#hidden-val').text($('#my_hidden_input').val());
		});
	});
*/

$('#pickyDate').datepicker({
  format: "dd/mm/yyyy",
  todayBtn: "linked",
  language: "pt-BR",
}).on('changeDate', showTestDate);

function showTestDate(){
  var value = $('#pickyDate').datepicker('getFormattedDate');
  $("#datafiltro").val(value);
}





});