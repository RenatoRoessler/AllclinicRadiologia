var ImportarAgenda = function(){
	var _self = this;



	this.importar = function() {
		$("#response").attr("class", "");
		$("#response").html("");
		var fileType = ".csv";
		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
				+ fileType + ")$");
		if (!regex.test($("#file").val().toLowerCase())) {
			$("#response").addClass("error");
			$("#response").addClass("display-block");
			$("#response").html(
					"Invalid File. Upload : <b>" + fileType
							+ "</b> Files.");
			mensagem('e', 'Selecione um arquivo Valido!')
			return false;
		}
		$("#formulario").submit();
		return true;
	};

}

$("document").ready(function(){
	var controle = new ImportarAgenda();

	$("#btnSalvar")
	.click(function(){
		controle.importar();
	});	



});
