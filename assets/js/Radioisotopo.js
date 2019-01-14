var Radioisotopo = function(){
	var _self = this;
	
	this.excluir = function(a){
		if(document.getElementById("FFCODRADIOISOTOPO").value > 0){
			dialogo({
				"titulo":'Excluir Eluição Radioisótopo',
				"texto":'Deseja Excluir',
				"fnc1":function(){
					$.ajax({
						url : '/AllclinicRadiologia/Radioisotopo/excluir/',
						type : 'POST',
						timeout: 30000,
						data : {
							'Codigo' : $('#FFCODRADIOISOTOPO').val(),
						},
						beforeSend: function(){
							loader('show');
						},
						success: function( retorno ){
							var j = jsonEncode( retorno, 'json' );
							mensagem(j.content.tipoMsg , j.content.Mensagem);
							loader('hide');	
							if(j.content.tipoMsg == 's'){
								ir('/AllclinicRadiologia/Radioisotopo');
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

	this.salvar  = function() {
		if($('#FFDESCRICAO').value() == ""){
			mensagem( 'e', 'Informe a desrcição');
			return false;
		}
		$("#formularioCadastro").submit();

	}

}

$("document").ready(function(){
	var controle = new Radioisotopo();

    
	$("#btnSearch")
	.click(function(){
		$("#formulario").submit();
	});
	
	$("#btnNovo")
	.click(function(){
		ir('/AllclinicRadiologia/Radioisotopo/novo');
	});

	$("#btnLimpar")
		.click(function(){
			$("input").val('');
			$('#btnSearch').trigger('click')
	});	
	
	$("#btnSalvar")
	.click(function(){
		//this.salvar();
		$("#formularioCadastro").submit();
	});

	$("#btnVoltar")
	.click(function(){
		ir('/AllclinicRadiologia/Radioisotopo');
	});	

	$("#btnExcluirRadioisotopo")
	.click(function(){
		controle.excluir();
	});

});